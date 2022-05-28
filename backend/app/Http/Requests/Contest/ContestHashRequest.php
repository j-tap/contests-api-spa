<?php

namespace App\Http\Requests\Contest;

use Illuminate\Foundation\Http\FormRequest;

class ContestHashRequest extends FormRequest
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
        $request['hash'] = $this->route('hash');
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
            'hash' => [
                'required',
                'exists:invites,id',
            ]
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
            'exists' => __('validation.exists'),
        ];
    }
}
