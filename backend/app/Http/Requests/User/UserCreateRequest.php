<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'min:6',
                'string',
                'confirmed',
            ],
            'role_id' => [
                'required',
                'integer',
                'exists:roles,id',
            ],
            'companies' => [
                'required',
                'array',
                'exists:companies,id',
            ],
        ];
    }

    /**
     * messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => __('validation.required'),
            'email' => __('validation.email'),
            'min' => __('validation.min'),
            'string' => __('validation.string'),
            'max' => __('validation.max'),
            'unique' => __('validation.unique'),
            'confirmed' => __('validation.confirmed'),
            'integer' => __('validation.integer'),
            'exists' => __('validation.exists'),
            'array' => __('validation.array'),
        ];
    }
}
