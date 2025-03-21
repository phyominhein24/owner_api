<?php

namespace App\Http\Controllers;

use App\Http\Requests\OwnerStoreRequest;
use App\Http\Requests\OwnerUpdateRequest;
use App\Models\Member;
use App\Models\Routes;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    public function index(Request $request)
    {
        DB::beginTransaction();
        try {
            $owners = Owner::sortingQuery()
                ->searchQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            $owners->transform(function ($owner) {
                $owner->created_by = $owner->created_by ? User::find($owner->created_by)->name : "Unknown";
                $owner->updated_by = $owner->updated_by ? User::find($owner->updated_by)->name : "Unknown";
                $owner->deleted_by = $owner->deleted_by ? User::find($owner->deleted_by)->name : "Unknown";
                return $owner;
            });
            DB::commit();
            return $this->success('owners retrived successfully', $owners);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function store(OwnerStoreRequest $request)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $owner = Owner::create($payload->toArray());
            DB::commit();
            return $this->success('owner created successfully', $owner);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $owner = Owner::findOrFail($id);
            DB::commit();
            return $this->success('owner retrived successfully by id', $owner);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function update(OwnerUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $owner = Owner::findOrFail($id);
            $owner->update($payload->toArray());
            DB::commit();
            return $this->success('owner updated successfully by id', $owner);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $owner = Owner::findOrFail($id);
            $owner->forceDelete();
            DB::commit();
            return $this->success('owner deleted successfully by id', []);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }
}