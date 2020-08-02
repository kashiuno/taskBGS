<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParticipantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|unique:participants|max:255',
            'event_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Field name is required',
            'name.max:255' => 'Name max length is 255 characters',
            'surname.required' => 'Field surname is required',
            'surname.max:255' => 'Surname max length is 255 characters',
            'email.required' => 'Email is required',
            'email.email' => 'It is a not valid email address',
            'email.unique' => 'Participant with current email exist',
            'email.max:255' => 'Email max length is 255 characters',
            'event_id.required' => 'Event is required',
            'event_id.integer' => 'Event must be an integer'
        ];
    }
}
