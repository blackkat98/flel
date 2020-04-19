<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestQuizRequest extends FormRequest
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

    public function rules()
    {
        switch ($this->route()->getName()) {
            case 'admin-test-quizzes-store':
                return [
                    'number' => 'required',
                    'question' => 'required'
                ];
            case 'admin-test-quizzes-update':
                return [
                    'number' => 'required',
                    'question' => 'required'
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
            'number.required' => __('Number') . ' ' . __('is required'),
            'question.required' => __('Question') . ' ' . __('is required')
        ];
    }
}
