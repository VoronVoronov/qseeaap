<?php

namespace App\Http\Requests\API\v1\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'phone' => 'required|integer|unique:users,phone',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
            'agreement' => 'required|accepted',
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
            'name.required' => __('user.name_required'),
            'phone.required' => __('user.phone_required'),
            'phone.unique' => __('user.phone_unique'),
            'password.required' => __('user.password_required'),
            'password.min' => __('user.password_min'),
            'password_confirmation.required' => __('user.password_confirmation_required'),
            'password_confirmation.same' => __('user.password_confirmation_same'),
        ];
    }

    public function all($keys = null): array
    {
        $data = parent::all($keys);
        $data['phone'] = preg_replace('/[^0-9]/', '', $data['phone']);
        return $data;
    }
}
