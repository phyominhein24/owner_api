<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\RenterStatusEnum;
use App\Helpers\Enum;

class OwnerDataStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $enum = implode(',', (new Enum(RenterStatusEnum::class))->values());

        return [
            'owner_id' => 'required|exists:owners,id',
            'corner_id' => 'required|exists:corners,id',
            'city_id' => 'required|exists:cities,id',
            'township_id' => 'required|exists:townships,id',
            'ward_id' => 'required|exists:wards,id',
            'street_id' => 'required|exists:streets,id',
            'wifi_id' => 'required|exists:wifis,id',
            'land_no' => 'required|string|max:255',
            'house_no' => 'required|string|max:255',
            'property' => 'required|string|max:255',
            'meter_no' => 'required|string|max:255',
            'meter_bill_code' => 'required|string|max:255',
            'wifi_user_id' => 'required|string|max:255',
            'land_id' => 'required|exists:lands,id',
            'issuance_date' => 'required|date',
            'expired' => 'required|date',
            'renter_id' => 'nullable|exists:renters,id',
            'status' => "nullable|in:$enum"
            
            // 'contract_date' => 'nullable|date',
            // 'end_of_contract_date' => 'nullable|date',
            // 'price_per_month' => 'nullable|numeric',
            // 'total_months' => 'nullable|integer',
            // 'notes' => 'nullable|string',
            // 'photos' => 'nullable|array',
            // 'photos.*' => 'file|image|max:2048'
        ];
    }
}
