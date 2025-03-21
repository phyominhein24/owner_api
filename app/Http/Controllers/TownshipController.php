<?php

namespace App\Http\Controllers;

use App\Http\Requests\TownshipStoreRequest;
use App\Http\Requests\TownshipUpdateRequest;
use App\Models\Member;
use App\Models\Routes;
use App\Models\Township;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TownshipController extends Controller
{
    public function index(Request $request)
    {
        DB::beginTransaction();
        try {
            $townships = Township::sortingQuery()
                ->searchQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            $townships->transform(function ($township) {
                $township->created_by = $township->created_by ? User::find($township->created_by)->name : "Unknown";
                $township->updated_by = $township->updated_by ? User::find($township->updated_by)->name : "Unknown";
                $township->deleted_by = $township->deleted_by ? User::find($township->deleted_by)->name : "Unknown";
                return $township;
            });
            DB::commit();
            return $this->success('townships retrived successfully', $townships);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function store(TownshipStoreRequest $request)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $township = Township::create($payload->toArray());
            DB::commit();
            return $this->success('township created successfully', $township);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $township = Township::findOrFail($id);
            DB::commit();
            return $this->success('township retrived successfully by id', $township);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function update(TownshipUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $township = Township::findOrFail($id);
            $township->update($payload->toArray());
            DB::commit();
            return $this->success('township updated successfully by id', $township);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $township = Township::findOrFail($id);
            $township->forceDelete();
            DB::commit();
            return $this->success('township deleted successfully by id', []);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }
}