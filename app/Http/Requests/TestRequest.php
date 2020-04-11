<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
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
            case 'admin-tests-store':
                return [
                    'name' => 'required|unique:tests',
                    'test_type_id' => 'required'
                ];
            case 'admin-tests-update':
                return [
                    'name' => 'required|unique:tests,name,' . $this->id,
                    'test_type_id' => 'required'
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
            'test_type_id.required' => __('Type') . ' ' . __('is required')
        ];
    }
}
