<?php

namespace App\Http\Requests\Api\Role;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
        $rules = [
            'name' => 'string',
            'allpermission' => 'boolean',
            'description' => 'string|nullable',
        ];
        foreach ($this->request->get('permissions', []) as $key => $val) {
            $rules['permissions.' . $key] = 'exists:permissions,slug';
        }
        return $rules;
    }
}
