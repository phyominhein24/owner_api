<?php

namespace App\Http\Controllers;

use App\Http\Requests\LandStoreRequest;
use App\Http\Requests\LandUpdateRequest;
use App\Models\Member;
use App\Models\Routes;
use App\Models\Land;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandController extends Controller
{
    public function index(Request $request)
    {
        DB::beginTransaction();
        try {
            $lands = Land::sortingQuery()
                ->searchQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            $lands->transform(function ($land) {
                $land->created_by = $land->created_by ? User::find($land->created_by)->name : "Unknown";
                $land->updated_by = $land->updated_by ? User::find($land->updated_by)->name : "Unknown";
                $land->deleted_by = $land->deleted_by ? User::find($land->deleted_by)->name : "Unknown";
                return $land;
            });
            DB::commit();
            return $this->success('lands retrived successfully', $lands);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function store(LandStoreRequest $request)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $land = Land::create($payload->toArray());
            DB::commit();
            return $this->success('land created successfully', $land);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $land = Land::findOrFail($id);
            DB::commit();
            return $this->success('land retrived successfully by id', $land);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function update(LandUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $land = Land::findOrFail($id);
            $land->update($payload->toArray());
            DB::commit();
            return $this->success('land updated successfully by id', $land);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $land = Land::findOrFail($id);
            $land->forceDelete();
            DB::commit();
            return $this->success('land deleted successfully by id', []);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }
}