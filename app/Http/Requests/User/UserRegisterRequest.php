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
     * rebuild or add value before validate
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        if(isset($this->email)){
            $this->username = Str::slug($this->email);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "password"          => "required|max:50|min:4",
            "password-confirm"  => "required|max:50|min:4|same:password",
            "fullname"          => "required",
            "email"             => "required|email:rfc,dns|unique:users",
            "phone"             => "required",
            "birthday"          => "required|date",
        ];
    }

    public function messages()
    {
        return [
            'password.required'     => Lang::get("auth.password_required"),
            'password.min'          => Lang::get("auth.password_min"),
            'password.max'          => Lang::get("auth.password_max"),
            "password-confirm.same" => Lang::get("auth.password_not_same"),
            'fullname.required'     => Lang::get("auth.fullname_required"),
            'email.required'        => Lang::get("auth.email_required"),
            'email.email'           => Lang::get("auth.email_fail_type"),
            'phone.required'        => Lang::get("auth.phone_required"),
        ];
    }
}
