<?php

namespace App\Http\Requests;

use App\Enums\GeneralStatusEnum;
use App\Helpers\Enum;
use App\Models\Street;
use Illuminate\Foundation\Http\FormRequest;

class StreetUpdateRequest extends FormRequest
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
        $street = Street::findOrFail(request('id'));
        $streetId = $street->id;

        return [
            'name' => "required|string| unique:streets,name,$streetId| max:1000 | min:1"
        ];
    }
}
