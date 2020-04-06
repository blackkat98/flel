<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestTypeRequest extends FormRequest
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
            case 'admin-test-types-store':
                return [
                    'name' => 'required|unique:test_types',
                    'language_id' => 'required'
                ];
            case 'admin-test-types-update':
                return [
                    'name' => 'required|unique:test_types,name,' . $this->id,
                    'language_id' => 'required'
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
            'name.required' => __('Name') . ' ' . __('is required'),
            'name.unique' => __('Name') . ' ' . __('must be unique'),
            'language_id.required' => __('Language') . ' ' . __('is required')
        ];
    }
}
