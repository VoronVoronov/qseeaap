<?php

namespace App\Http\Requests\API\v1\Menu;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            'banner' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
