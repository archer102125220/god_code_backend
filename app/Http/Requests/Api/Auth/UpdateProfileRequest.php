<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

use Auth;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string',
            'email' => 'string|email',
            'phone' => 'string|nullable',
            'password_old' => 'required_with:password_old,password,password_confirmation|string',
            'password' => 'required_with:password_old,password,password_confirmation|string|confirmed',
            'password_confirmation' => 'required_with:password_old,password,password_confirmation|string'
        ];
    }
}
