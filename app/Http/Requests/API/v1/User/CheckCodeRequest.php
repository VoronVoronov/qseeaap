<?php

namespace App\Http\Requests\API\v1\User;

use Illuminate\Foundation\Http\FormRequest;

class CheckCodeRequest extends FormRequest
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
            'phone' => 'required|string',
            'code' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone.required' => __('user.phone_required'),
            'code.required' => __('user.code_required'),
        ];
    }

    public function all($keys = null): array
    {
        $data = parent::all($keys);
        $data['phone'] = preg_replace('/[^0-9]/', '', $data['phone']);
        return $data;
    }
}
