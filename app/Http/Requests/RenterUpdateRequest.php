<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RenterUpdateRequest extends FormRequest
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
        $enum = implode(',', (new Enum(GeneralStatusEnum::class))->values());
        $renter = Renter::findOrFail(request('id'));
        $renterId = $renter->id;

        return [
            'name' => "required|string| unique:renters,name,$renterId| max:1000 | min:1",
            'status' => "required|in:$enum"
        ];
    }
}
