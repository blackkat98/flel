<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TutorContactRequest extends FormRequest
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
        switch ($this->route()->getName()) {
            case 'admin-tutor-contacts-store':
                return [
                    'user_id' => 'unique:tutor_contacts',
                    'real_name' => 'required'
                ];
            case 'admin-tutor-contacts-update':
                return [
                    'user_id' => 'unique:tutor_contacts,id,' . $this->id,
                    'real_name' => 'required'
                ];
        }
    }
    
    /**
     * Get the error messages for the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.unique' => __('User') . ' ' . __('must be unique'),
            'real_name.required' => __('Real Name') . ' ' . __('is required')
        ];
    }
}
