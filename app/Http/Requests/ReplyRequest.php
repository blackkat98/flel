<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyRequest extends FormRequest
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
            'content' => 'required'
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
            'content.required' => __('Content') . ' ' . __('is required')
        ];
    }
}
