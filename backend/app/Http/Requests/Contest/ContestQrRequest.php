<?php

namespace App\Http\Requests\Contest;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ContestActiveRule;

class ContestQrRequest extends FormRequest
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
     * all
     *
     * @param  mixed $keys
     * @return void
     */
    public function all($keys = null)
    {
        $request = parent::all($keys);
        $request['id'] = $this->route('id');
        return $request;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => [
                'required',
                'exists:contests,id',
                new ContestActiveRule,
            ],
            'number_color' => [
                'integer',
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
            'integer' => __('validation.integer'),
            'required' => __('validation.required'),
            'exists' => __('validation.exists'),
        ];
    }
}
