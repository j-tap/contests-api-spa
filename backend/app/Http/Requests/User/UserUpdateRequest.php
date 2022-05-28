<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
                'string',
                'min:2',
                'max:255',
            ],
            'role_id' => [
                'integer',
                'exists:roles,id',
            ],
            'companies' => [
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
            'min' => __('validation.min'),
            'string' => __('validation.string'),
            'max' => __('validation.max'),
            'integer' => __('validation.integer'),
            'exists' => __('validation.exists'),
            'array' => __('validation.array'),
        ];
    }
}
