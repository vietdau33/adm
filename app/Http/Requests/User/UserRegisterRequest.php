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

    public function prepareForValidation()
    {
        $this->merge([
            'username' => strtolower($this->username),
            'email' => strtolower($this->email)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "password" => "required|string|max:50|min:4",
            "password-confirm" => "required|string|max:50|min:4|same:password",
            "fullname" => "required",
            "email" => "required|email:rfc|unique:users",
            "phone" => [
                'required',
                'regex:/(^(\+84|84|0|0084)(3|5|7|8|9))+(\d{8})$/i'
            ],
            "username" => [
                'required',
                'unique:users',
                'regex:/^(?=[a-zA-Z0-9._]{4,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/i'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => Lang::get("auth.password_required"),
            'password.min' => Lang::get("auth.password_min"),
            'password.max' => Lang::get("auth.password_max"),
            "password-confirm.same" => Lang::get("auth.password_not_same"),
            'fullname.required' => Lang::get("auth.fullname_required"),
            'email.required' => Lang::get("auth.email_required"),
            'email.email' => Lang::get("auth.email_fail_type"),
            'email.unique' => 'Email has exists!',
            'phone.required' => Lang::get("auth.phone_required"),
            'username.required' => 'Username is required!',
            'username.unique' => 'Username has exists!',
            'username.regex' => 'Invalid username. Valid username contains only unsigned characters and numbers, no periods and underscores before and after username'
        ];
    }
}
