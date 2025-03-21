<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityStoreRequest;
use App\Http\Requests\CityUpdateRequest;
use App\Models\Member;
use App\Models\Routes;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function index(Request $request)
    {
        DB::beginTransaction();
        try {
            $citys = City::sortingQuery()
                ->searchQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            $citys->transform(function ($city) {
                $city->created_by = $city->created_by ? User::find($city->created_by)->name : "Unknown";
                $city->updated_by = $city->updated_by ? User::find($city->updated_by)->name : "Unknown";
                $city->deleted_by = $city->deleted_by ? User::find($city->deleted_by)->name : "Unknown";
                return $city;
            });
            DB::commit();
            return $this->success('citys retrived successfully', $citys);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function store(CityStoreRequest $request)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $city = City::create($payload->toArray());
            DB::commit();
            return $this->success('city created successfully', $city);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $city = City::findOrFail($id);
            DB::commit();
            return $this->success('city retrived successfully by id', $city);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function update(CityUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $city = City::findOrFail($id);
            $city->update($payload->toArray());
            DB::commit();
            return $this->success('city updated successfully by id', $city);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $city = City::findOrFail($id);
            $city->forceDelete();
            DB::commit();
            return $this->success('city deleted successfully by id', []);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }
}