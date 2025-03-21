<?php

namespace App\Http\Controllers;

use App\Http\Requests\WifiStoreRequest;
use App\Http\Requests\WifiUpdateRequest;
use App\Models\Member;
use App\Models\Routes;
use App\Models\Wifi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WifiController extends Controller
{
    public function index(Request $request)
    {
        DB::beginTransaction();
        try {
            $wifis = Wifi::sortingQuery()
                ->searchQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            $wifis->transform(function ($wifi) {
                $wifi->created_by = $wifi->created_by ? User::find($wifi->created_by)->name : "Unknown";
                $wifi->updated_by = $wifi->updated_by ? User::find($wifi->updated_by)->name : "Unknown";
                $wifi->deleted_by = $wifi->deleted_by ? User::find($wifi->deleted_by)->name : "Unknown";
                return $wifi;
            });
            DB::commit();
            return $this->success('wifis retrived successfully', $wifis);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function store(WifiStoreRequest $request)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $wifi = Wifi::create($payload->toArray());
            DB::commit();
            return $this->success('wifi created successfully', $wifi);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $wifi = Wifi::findOrFail($id);
            DB::commit();
            return $this->success('wifi retrived successfully by id', $wifi);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function update(WifiUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $wifi = Wifi::findOrFail($id);
            $wifi->update($payload->toArray());
            DB::commit();
            return $this->success('wifi updated successfully by id', $wifi);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $wifi = Wifi::findOrFail($id);
            $wifi->forceDelete();
            DB::commit();
            return $this->success('wifi deleted successfully by id', []);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }
}