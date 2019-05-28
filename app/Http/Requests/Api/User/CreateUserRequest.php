<?php

namespace App\Http\Requests\Api\User;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'username' => 'string|unique:users,username',
            'password' => 'string|confirmed',
            'password_confirmation' => 'string',
            'name' => 'string',
            'email' => 'string|email',
            'phone' => 'string|nullable',
            'role_id' => 'integer|exists:roles,id|nullable',
        ];
    }
}
