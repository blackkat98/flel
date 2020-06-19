<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            case 'admin-users-store':
                return [
                    'name' => 'required|string',
                    'email' => 'required|string|email|unique:users',
                    'password' => 'required|string|min:6',
                ];
            case 'admin-users-update':
                return [
                    'name' => 'required|string',
                    'email' => 'required|string|email|unique:users,email,' . $this->id,
                    'password' => 'required|string|min:6',
                ];
            case 'home-me-profile-update':
                return [
                    'name' => 'required|string',
                    'email' => 'required|string|email|unique:users,email,' . $this->id
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
            'name.string' => __('Name') . ' ' . __('must not contain spaces'),
            'email.required' => __('Email') . ' ' . __('is required'),
            'email.unique' => __('Email') . ' ' . __('must be unique'),
            'email.email' => __('Email') . ' ' . __('is not in the correct form'),
            'password.required' => __('Password') . ' ' . __('is required'),
            'password.string' => __('Password') . ' ' . __('must not contain spaces'),
            'password.min' =>  __('Password') . ' ' . __('must have a size of at least') . ' 6'
        ];
    }
}
