<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractStoreRequest;
use App\Http\Requests\ContractUpdateRequest;
use App\Models\Member;
use App\Models\Routes;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        DB::beginTransaction();
        try {
            $contracts = Contract::sortingQuery()
                ->searchQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            $contracts->transform(function ($contract) {
                $contract->created_by = $contract->created_by ? User::find($contract->created_by)->name : "Unknown";
                $contract->updated_by = $contract->updated_by ? User::find($contract->updated_by)->name : "Unknown";
                $contract->deleted_by = $contract->deleted_by ? User::find($contract->deleted_by)->name : "Unknown";
                return $contract;
            });
            DB::commit();
            return $this->success('contracts retrived successfully', $contracts);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function store(ContractStoreRequest $request)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {

            if ($request->hasFile('photos')) {
                $photoPaths = [];
        
                foreach ($request->file('photos') as $photo) {
                    $photoPaths[] = $photo->store('contracts/photos', 'public'); // saves to storage/app/public/contracts/photos
                }
        
                $payload['photos'] = $photoPaths;
            }

            $contract = Contract::create($payload->toArray());
            DB::commit();
            return $this->success('contract created successfully', $contract);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $contract = Contract::findOrFail($id);
            DB::commit();
            return $this->success('contract retrived successfully by id', $contract);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function update(ContractUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        $payload = collect($request->validated());
        try {
            $contract = Contract::findOrFail($id);
            $contract->update($payload->toArray());
            DB::commit();
            return $this->success('contract updated successfully by id', $contract);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $contract = Contract::findOrFail($id);
            $contract->forceDelete();
            DB::commit();
            return $this->success('contract deleted successfully by id', []);
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }
}