<?php

namespace App\Http\Controllers;

use App\Http\Requests\WardStoreRequest;
use App\Http\Requests\WardUpdateRequest;
use App\Models\Member;
use App\Models\Routes;
use App\Models\Ward;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WardController extends Controller
{
    public function index(Request $request)
    {
        DB::beginTransaction();
        try {
            $wards = Ward::sortingQuery()
                ->searchQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            $wards->transform(function ($ward) {
                $ward->created_by = $ward->created_by ? User::find($ward->created_by)->name : "Unknown";
                $ward->updated_by = $ward->updated_by ? User::find($ward->updated_by)->name : "Unknown";
                $ward->deleted_by = $ward->deleted_by ? User::find($ward->deleted_by)->name : "Unknown";
                return $ward;
            });
            DB::commit();
            return $this->success('wards retrived successfully', $wards);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function store(WardStoreRequest $request)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $ward = Ward::create($payload->toArray());
            DB::commit();
            return $this->success('ward created successfully', $ward);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $ward = Ward::findOrFail($id);
            DB::commit();
            return $this->success('ward retrived successfully by id', $ward);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function update(WardUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $ward = Ward::findOrFail($id);
            $ward->update($payload->toArray());
            DB::commit();
            return $this->success('ward updated successfully by id', $ward);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $ward = Ward::findOrFail($id);
            $ward->forceDelete();
            DB::commit();
            return $this->success('ward deleted successfully by id', []);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }
}