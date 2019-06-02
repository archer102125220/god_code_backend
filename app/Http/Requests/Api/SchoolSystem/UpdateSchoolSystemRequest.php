<?php

namespace App\Http\Requests\Api\SchoolSystem;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolSystemRequest extends FormRequest
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
            'school_systems' => 'string|required',
        ];

        return $rules;
    }
}
