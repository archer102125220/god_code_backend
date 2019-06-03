<?php

namespace App\Http\Requests\Api\ResearchType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResearchTypeRequest extends FormRequest
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
            'research_types' => 'string|required',
        ];

        return $rules;
    }
}
