<?php

namespace App\Http\Requests\Api\SchoolSystem;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateSchoolSystemRequest extends FormRequest
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
        //要驗證的資料規則
        $rules = [
            'school_systems' => 'string|required',
        ];

        return $rules;
    }
}
