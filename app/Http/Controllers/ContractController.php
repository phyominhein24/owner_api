<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractStoreRequest;
use App\Http\Requests\ContractUpdateRequest;
use App\Models\Member;
use App\Models\Routes;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

            $photoPaths = [];
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('images', 'public');
                    $photoPaths[] = $path;
                }
            }

            $payload['photos'] = $photoPaths;

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

        try {
            $contract = Contract::findOrFail($id);
            $payload = collect($request->validated());

            // Get old photo paths from DB (assuming it's stored as an array)
            $oldPhotos = $contract->photos ?? [];

            $finalPhotos = [];

            $rawPhotos = $request->input('photos', []); // get all inputs under 'photos'
            $filePhotos = $request->file('photos', []); // get all UploadedFile under 'photos'

            // Handle string inputs first (old photos to keep)
            if (is_array($rawPhotos)) {
                foreach ($rawPhotos as $item) {
                    if (is_string($item)) {
                        $finalPhotos[] = $item;
                    }
                }
            }

            // Handle new uploaded files
            if (is_array($filePhotos)) {
                foreach ($filePhotos as $file) {
                    if ($file instanceof \Illuminate\Http\UploadedFile) {
                        $path = $file->store('images', 'public');
                        $finalPhotos[] = $path;
                    }
                }
            }

            // Determine which old photos should be deleted
            $deletedPhotos = array_diff($oldPhotos, $finalPhotos);
            foreach ($deletedPhotos as $photo) {
                Storage::disk('public')->delete($photo);
            }

            // Store merged photo list
            $payload['photos'] = $finalPhotos;

            $contract->update($payload->toArray());

            DB::commit();
            return $this->success('Contract updated successfully', $contract);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->internalServerError($e->getMessage());
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