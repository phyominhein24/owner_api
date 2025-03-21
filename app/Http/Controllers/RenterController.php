<?php

namespace App\Http\Controllers;

use App\Http\Requests\RenterStoreRequest;
use App\Http\Requests\RenterUpdateRequest;
use App\Models\Member;
use App\Models\Routes;
use App\Models\Renter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RenterController extends Controller
{
    public function index(Request $request)
    {
        DB::beginTransaction();
        try {
            $renters = Renter::sortingQuery()
                ->searchQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            $renters->transform(function ($renter) {
                $renter->created_by = $renter->created_by ? User::find($renter->created_by)->name : "Unknown";
                $renter->updated_by = $renter->updated_by ? User::find($renter->updated_by)->name : "Unknown";
                $renter->deleted_by = $renter->deleted_by ? User::find($renter->deleted_by)->name : "Unknown";
                return $renter;
            });
            DB::commit();
            return $this->success('renters retrived successfully', $renters);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function store(RenterStoreRequest $request)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $renter = Renter::create($payload->toArray());
            DB::commit();
            return $this->success('renter created successfully', $renter);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $renter = Renter::findOrFail($id);
            DB::commit();
            return $this->success('renter retrived successfully by id', $renter);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function update(RenterUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $renter = Renter::findOrFail($id);
            $renter->update($payload->toArray());
            DB::commit();
            return $this->success('renter updated successfully by id', $renter);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $renter = Renter::findOrFail($id);
            $renter->forceDelete();
            DB::commit();
            return $this->success('renter deleted successfully by id', []);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }
}