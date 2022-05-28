<?php

namespace App\Http\Requests\Setting;

use Dotenv\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateMultipleRequest extends FormRequest
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
    public function rules(): Array
    {
        return [
            'list' => ['required', 'array'],
            'list.*' => ['required', 'array'],
            'list.*.id' => ['required', 'integer', 'exists:settings,id'],
            'list.*.key' => ['required', 'string'],
            'list.*.value' => ['present'],
        ];
    }

    /**
     * messages
     *
     * @return array
     */
    public function messages(): Array
    {
        return [
            // 'array' => __('validation.array'),
            'required' => __('validation.required'),
            'integer' => __('validation.integer'),
            'exists' => __('validation.exists'),
        ];
    }

}
