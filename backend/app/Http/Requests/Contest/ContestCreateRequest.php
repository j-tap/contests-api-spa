<?php

namespace App\Http\Requests\Contest;

use Illuminate\Foundation\Http\FormRequest;

class ContestCreateRequest extends FormRequest
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
                'max:255',
            ],
            'company_id' => [
                'required',
                'integer',
                'exists:companies,id',
            ],
            'landing_template_id' => [
                'required',
                'integer',
                'exists:landing_templates,id',
            ],
            'status_id' => [
                'integer',
                'exists:statuses,id',
            ],
            'active' => [
                'boolean',
            ],
            'date_from' => [
                'nullable',
                'date',
            ],
            'date_to' => [
                'nullable',
                'date',
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
            'boolean' => __('validation.boolean'),
            'date' => __('validation.date'),
        ];
    }
}
