<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class UserRegisterRequest extends FormRequest
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
            "password"          => "required|string|max:50|min:4",
            "password-confirm"  => "required|string|max:50|min:4|same:password",
            "fullname"          => "required",
            "email"             => "required|email:rfc|unique:users",
            "phone"             => "required",
            "username"          => "required|unique:users",
        ];
    }

    public function messages(): array
    {
        return [
            'password.required'     => Lang::get("auth.password_required"),
            'password.min'          => Lang::get("auth.password_min"),
            'password.max'          => Lang::get("auth.password_max"),
            "password-confirm.same" => Lang::get("auth.password_not_same"),
            'fullname.required'     => Lang::get("auth.fullname_required"),
            'email.required'        => Lang::get("auth.email_required"),
            'email.email'           => Lang::get("auth.email_fail_type"),
            'email.unique'          => 'Email has exists!',
            'phone.required'        => Lang::get("auth.phone_required"),
            'username.required'     => 'Username is required!',
            'username.unique'       => 'Username has exists!',
        ];
    }
}
