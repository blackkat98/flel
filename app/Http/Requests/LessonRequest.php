<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
            'number' => 'required',
            'name' => 'required',
            'lecture' => 'required'
        ];
    }

    /**
     * Get the error messages for the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'number.required' => __('Name') . ' ' . __('is required'),
            'name.required' => __('Name') . ' ' . __('is required'),
            'lecture.required' => __('Type') . ' ' . __('is required')
        ];
    }
}
