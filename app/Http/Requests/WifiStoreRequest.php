<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WifiStoreRequest extends FormRequest
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

        return [
            'name' => 'required|string| unique:wifis,name| max:1000 | min:1',
            'status' => "nullable|in:$enum"
        ];
    }
}
