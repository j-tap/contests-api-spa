<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingCreateRequest extends FormRequest
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
            'key' => [
                'required',
                'string',
                'max:255',
            ],
            'value' => [],
            'setting_type_id' => [
                'required',
                'integer',
                'exists:setting_types,id',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'company_id' => [
                'nullable',
                'integer',
                'exists:companies,id',
            ],
            'contest_id' => [
                'nullable',
                'integer',
                'exists:contests,id',
            ],
            'description' => [
                'nullable',
                'string',
                'max:255',
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
            'max' => __('validation.max'),
            'integer' => __('validation.integer'),
            'exists' => __('validation.exists'),
        ];
    }
}
