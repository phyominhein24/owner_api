<?php

namespace App\Http\Controllers;

use App\Http\Requests\OwnerDataStoreRequest;
use App\Http\Requests\OwnerDataUpdateRequest;
use App\Models\Member;
use App\Models\Routes;
use App\Models\OwnerData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerDataController extends Controller
{
    public function index(Request $request)
    {
        DB::beginTransaction();
        try {
            $ownerDatas = OwnerData::sortingQuery()
                ->searchQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            $ownerDatas->transform(function ($ownerData) {
                $ownerData->created_by = $ownerData->created_by ? User::find($ownerData->created_by)->name : "Unknown";
                $ownerData->updated_by = $ownerData->updated_by ? User::find($ownerData->updated_by)->name : "Unknown";
                $ownerData->deleted_by = $ownerData->deleted_by ? User::find($ownerData->deleted_by)->name : "Unknown";
                return $ownerData;
            });
            DB::commit();
            return $this->success('ownerDatas retrived successfully', $ownerDatas);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function store(OwnerDataStoreRequest $request)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $ownerData = OwnerData::create($payload->toArray());
            DB::commit();
            return $this->success('ownerData created successfully', $ownerData);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $ownerData = OwnerData::findOrFail($id);
            DB::commit();
            return $this->success('ownerData retrived successfully by id', $ownerData);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function update(OwnerDataUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $ownerData = OwnerData::findOrFail($id);
            $ownerData->update($payload->toArray());
            DB::commit();
            return $this->success('ownerData updated successfully by id', $ownerData);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $ownerData = OwnerData::findOrFail($id);
            $ownerData->forceDelete();
            DB::commit();
            return $this->success('ownerData deleted successfully by id', []);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }
}