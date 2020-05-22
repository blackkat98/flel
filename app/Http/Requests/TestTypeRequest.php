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
                    'slug' => 'required|unique:test_types|regex:/(^([a-z-?]+)(\d+)?$)/u',
                    'language_id' => 'required',
                    'fixed_quiz_quantity' => 'required|min:0|max:250',
                    'fixed_time' => 'required|min:0'
                ];
            case 'admin-test-types-update':
                return [
                    'name' => 'required|unique:test_types,name,' . $this->id,
                    'slug' => 'required|unique:test_types,slug,' . $this->id . '|regex:/(^([a-z-?]+)(\d+)?$)/u',
                    'language_id' => 'required',
                    'fixed_quiz_quantity' => 'required|min:0|max:250',
                    'fixed_time' => 'required|min:0'
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
            'slug.regex' => __('Slug') . ' ' . __('is not in the correct form'),
            'language_id.required' => __('Language') . ' ' . __('is required'),
            'fixed_quiz_quantity.required' => __('Number of') . ' ' . __('Quizzes') . ' ' . __('is required'),
            'fixed_quiz_quantity.min' =>  __('Number of') . ' ' . __('Quizzes') . ' ' . __('must be at least') . ' 0',
            'fixed_quiz_quantity.max' =>  __('Number of') . ' ' . __('Quizzes') . ' ' . __('must be at most') . ' 0',
            'fixed_time.required' => __('Time') . ' ' . __('is required'),
            'fixed_time.min' =>  __('Time') . ' ' . __('must be at least') . ' 0'
        ];
    }
}
