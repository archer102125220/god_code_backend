<?php

namespace App\Http\Requests\Api\Interest;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateInterestRequest extends FormRequest
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
            'interests' => 'string|required'
        ];
        return $rules;
    }
}
