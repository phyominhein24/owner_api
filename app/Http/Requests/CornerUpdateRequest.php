<?php

namespace App\Http\Requests;

use App\Models\Corner;
use Illuminate\Foundation\Http\FormRequest;

class CornerUpdateRequest extends FormRequest
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
        $corner = Corner::findOrFail(request('id'));
        $cornerId = $corner->id;

        return [
            'name' => "required|string| unique:corners,name,$cornerId| max:1000 | min:1"
        ];
    }
}
