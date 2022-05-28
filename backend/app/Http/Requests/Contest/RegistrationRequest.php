<?php

namespace App\Http\Requests\Contest;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\RecaptchaRule;
// use App\Rules\TgUsernameRule;
use App\Rules\TgInChannelRule;
use App\Rules\HashActiveRule;
use App\Rules\HashContestActiveRule;

class RegistrationRequest extends FormRequest
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
        $hash = $this->hash;

        return [
            'g-recaptcha-response' => [
                'required',
                // TODO: Включить после тестирования!
                // new RecaptchaRule,
            ],
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'unique:users',
            ],
            'career' => [
                'required',
                'string',
                'min:2',
            ],
            'accept_rules' => [
                'required',
                'accepted',
            ],
            'accept_personal_data' => [
                'required',
                'accepted',
            ],
            'hash' => [
                'required',
                'exists:invites',
                'bail',
                new HashActiveRule,
                new HashContestActiveRule,
            ],
            'telegram' => [
                'required',
                'min:5',
                'max:32',
                'regex:/^([A-z]|[0-9]|[_@])*$/',
                'unique:user_metas',
                'bail',
                new TgInChannelRule($hash),
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
            'accepted' => __('validation.accepted'),
        ];
    }
}
