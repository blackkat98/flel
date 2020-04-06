<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
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
            case 'admin-languages-store':
                return [
                    'name' => 'required|unique:languages',
                    'slug' => 'required|size:2|unique:languages'
                ];
            case 'admin-languages-update':
                return [
                    'name' => 'required|unique:languages,name,' . $this->id,
                    'slug' => 'required|size:2|unique:languages,slug,' . $this->id
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
            'slug.required' => __('Slug') . ' ' . __('is required'),
            'slug.unique' => __('Slug') . ' ' . __('must be unique'),
            'slug.size' =>  __('Slug') . ' ' . __('must has a size of') . ' 2'
        ];
    }
}
