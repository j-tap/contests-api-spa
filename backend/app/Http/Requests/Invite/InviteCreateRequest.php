<?php

namespace App\Http\Requests\Invite;

use Illuminate\Foundation\Http\FormRequest;

class InviteCreateRequest extends FormRequest
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
            'hash' => [
                'required',
                'string',
                'unique:invites',
            ],
            'contest_id' => [
                'required',
                'integer',
                'exists:contests,id',
            ],
            'manager_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'user_id' => [
                'nullable',
                'integer',
                'exists:users,id',
            ],
            'active' => [
                'boolean',
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
            'string' => __('validation.string'),
            'unique' => __('validation.unique'),
            'integer' => __('validation.integer'),
            'exists' => __('validation.exists'),
            'boolean' => __('validation.boolean'),
        ];
    }
}
