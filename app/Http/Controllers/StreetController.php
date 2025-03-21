<?php

namespace App\Http\Controllers;

use App\Http\Requests\StreetStoreRequest;
use App\Http\Requests\StreetUpdateRequest;
use App\Models\Member;
use App\Models\Routes;
use App\Models\Street;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StreetController extends Controller
{
    public function index(Request $request)
    {
        DB::beginTransaction();
        try {
            $streets = Street::sortingQuery()
                ->searchQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            $streets->transform(function ($street) {
                $street->created_by = $street->created_by ? User::find($street->created_by)->name : "Unknown";
                $street->updated_by = $street->updated_by ? User::find($street->updated_by)->name : "Unknown";
                $street->deleted_by = $street->deleted_by ? User::find($street->deleted_by)->name : "Unknown";
                return $street;
            });
            DB::commit();
            return $this->success('streets retrived successfully', $streets);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function store(StreetStoreRequest $request)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $street = Street::create($payload->toArray());
            DB::commit();
            return $this->success('street created successfully', $street);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $street = Street::findOrFail($id);
            DB::commit();
            return $this->success('street retrived successfully by id', $street);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function update(StreetUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $street = Street::findOrFail($id);
            $street->update($payload->toArray());
            DB::commit();
            return $this->success('street updated successfully by id', $street);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $street = Street::findOrFail($id);
            $street->forceDelete();
            DB::commit();
            return $this->success('street deleted successfully by id', []);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }
}