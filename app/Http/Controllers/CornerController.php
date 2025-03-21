<?php

namespace App\Http\Controllers;

use App\Http\Requests\CornerStoreRequest;
use App\Http\Requests\CornerUpdateRequest;
use App\Models\Member;
use App\Models\Routes;
use App\Models\Corner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CornerController extends Controller
{
    public function index(Request $request)
    {
        DB::beginTransaction();
        try {
            $corners = Corner::sortingQuery()
                ->searchQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            $corners->transform(function ($corner) {
                $corner->created_by = $corner->created_by ? User::find($corner->created_by)->name : "Unknown";
                $corner->updated_by = $corner->updated_by ? User::find($corner->updated_by)->name : "Unknown";
                $corner->deleted_by = $corner->deleted_by ? User::find($corner->deleted_by)->name : "Unknown";
                return $corner;
            });
            DB::commit();
            return $this->success('corners retrived successfully', $corners);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function store(CornerStoreRequest $request)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $corner = Corner::create($payload->toArray());
            DB::commit();
            return $this->success('corner created successfully', $corner);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $corner = Corner::findOrFail($id);
            DB::commit();
            return $this->success('corner retrived successfully by id', $corner);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function update(CornerUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $corner = Corner::findOrFail($id);
            $corner->update($payload->toArray());
            DB::commit();
            return $this->success('corner updated successfully by id', $corner);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $corner = Corner::findOrFail($id);
            $corner->forceDelete();
            DB::commit();
            return $this->success('corner deleted successfully by id', []);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }
}