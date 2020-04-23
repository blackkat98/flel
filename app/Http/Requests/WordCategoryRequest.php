<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WordCategoryRequest extends FormRequest
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
            case 'admin-word-categories-store':
                return [
                    'name' => 'required|unique:word_categories'
                ];
            case 'admin-word-categories-update':
                return [
                    'name' => 'required|unique:word_categories,name,' . $this->id
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
