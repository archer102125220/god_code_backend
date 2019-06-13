<?php

namespace App\Http\Requests\Api\EventAlbum;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEventAlbumRequest extends FormRequest
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
            'event_albums' => 'string|required',
            'event_type_id' => 'integer|required|exists:event_types,id'
        ];

        foreach ($this->request->get('files') as $key => $val) {
            $rules['files.' . $key] = 'required|exists:files,id';
        }

        return $rules;
    }
}
