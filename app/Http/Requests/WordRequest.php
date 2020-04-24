<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WordRequest extends FormRequest
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
            'word_category_id' => 'required',
            'word' => 'required',
            'definition' => 'required',
            'ipa' => 'required'
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
            'word_category_id.required' => __('Category') . ' ' . __('is required'),
            'word.required' => __('Word') . ' ' . __('is required'),
            'definition.required' => __('Definition') . ' ' . __('is required'),
            'ipa.required' => __('IPA') . ' ' . __('is required')
        ];
    }
}
