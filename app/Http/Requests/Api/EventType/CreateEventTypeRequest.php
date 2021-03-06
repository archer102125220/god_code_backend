<?php

namespace App\Http\Requests\Api\EventType;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateEventTypeRequest extends FormRequest
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
            'event_types' => 'string|required',
        ];

        return $rules;
    }
}
