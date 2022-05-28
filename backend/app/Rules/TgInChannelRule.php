<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Contest;
use App\Services\Invite\InviteService;
use App\Services\Tg\TgApi;

class TgInChannelRule implements Rule
{
    private $tgChannel = null;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($hash)
    {
        $inviteService = new InviteService();
        $invite = $inviteService->getByHash($hash);

        if ($invite)
        {
            $contestId = $invite->contest_id;
            $contest = Contest::findOrFail($contestId);
            $contestSetting = $contest->settings()
                ->firstWhere('key', 'telegram_channel');
            $this->tgChannel = $contestSetting->value;
        }
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->tgChannel)
        {
            $tgApi = app(TgApi::class);
            $userInChannel = $tgApi->getIdsMembersChannel($this->tgChannel, 'username');
            return in_array(str_replace('@', '', $value), $userInChannel, true);
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.telegram_in_channel');
    }
}
