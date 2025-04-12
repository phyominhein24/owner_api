<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractStoreRequest extends FormRequest
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
        return [
            'owner_data_id' => 'required|exists:owner_data,id',
            'contract_date' => 'nullable|date',
            'end_of_contract_date' => 'nullable|date',
            'price_per_month' => 'nullable|string|max:255',
            'total_months' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'photos' => 'nullable|array'
        ];
    }
}
