<?php

namespace App\Http\Controllers;

use App\Http\Requests\OwnerDataStoreRequest;
use App\Http\Requests\OwnerDataUpdateRequest;
use App\Models\Owner;
use App\Models\Corner;
use App\Models\City;
use App\Models\Township;
use App\Models\Ward;
use App\Models\Street;
use App\Models\Wifi;
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
                $ownerData->owner_id = $ownerData->owner_id ? Owner::find($ownerData->owner_id)->name : "Unknown";
                $ownerData->corner_id = $ownerData->corner_id ? Corner::find($ownerData->corner_id)->name : "Unknown";
                $ownerData->city_id = $ownerData->city_id ? City::find($ownerData->city_id)->name : "Unknown";
                $ownerData->township_id = $ownerData->township_id ? Township::find($ownerData->township_id)->name : "Unknown";
                $ownerData->ward_id = $ownerData->ward_id ? Ward::find($ownerData->ward_id)->name : "Unknown";
                $ownerData->street_id = $ownerData->street_id ? Street::find($ownerData->street_id)->name : "Unknown";
                $ownerData->wifi_id = $ownerData->wifi_id ? Wifi::find($ownerData->wifi_id)->name : "Unknown";
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