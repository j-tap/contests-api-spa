<?php

namespace App\Http\Requests\Contest;

use Illuminate\Foundation\Http\FormRequest;

class ContestUpdateRequest extends FormRequest
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
                'max:255',
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
            'status_id' => [
                'integer',
                'exists:statuses,id',
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
            'boolean' => __('validation.boolean'),
            'date' => __('validation.date'),
        ];
    }
}
