<?php

namespace App\Http\Requests;

use App\Enums\GeneralStatusEnum;
use App\Helpers\Enum;
use App\Models\Township;
use Illuminate\Foundation\Http\FormRequest;

class TownshipUpdateRequest extends FormRequest
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
        $township = Township::findOrFail(request('id'));
        $townshipId = $township->id;

        return [
            'name' => "required|string| unique:townships,name,$cornerId| max:1000 | min:1"
        ];
    }
}
