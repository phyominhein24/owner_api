<?php

namespace App\Http\Requests;

use App\Enums\GeneralStatusEnum;
use App\Helpers\Enum;
use App\Models\Ward;
use Illuminate\Foundation\Http\FormRequest;

class WardUpdateRequest extends FormRequest
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
        $ward = Ward::findOrFail(request('id'));
        $wardId = $ward->id;

        return [
            'name' => "required|string| unique:wards,name,$wardId| max:1000 | min:1"
        ];
    }
}
