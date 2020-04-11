<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestPartRequest extends FormRequest
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
            case 'admin-test-parts-store':
                return [
                    'name' => 'required|unique:test_parts'
                ];
            case 'admin-test-parts-update':
                return [
                    
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
            'name.unique' => __('Name') . ' ' . __('must be unique')
        ];
    }
}
