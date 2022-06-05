<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class UserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "username" => "required",
            "password" => "required"
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'username.required' => Lang::get("auth.username_required"),
            'password.required' => Lang::get("auth.password_required")
        ];
    }
}
