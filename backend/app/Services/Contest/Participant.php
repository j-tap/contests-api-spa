<?php

namespace App\Services\Contest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\Models\UserMeta;
use App\Models\Invite;
use App\Services\Contest\QrCode;
use App\Services\Invite\InviteService;
use App\Services\Tg\TgApi;

class Participant
{
    /**
     * Получение уникального QR кода для нового участника со ссылкой, текущим менеджером и временем генерации
     *
     * @param string $content
     * @param  int $color
     * @param  array $colors
     * @return QrCode
     */
    public static function getQrCode(string $content, int $numberColor, array $colors = []): QrCode
    {
        $qrCode = new QrCode(content: $content, color: $numberColor, colors: $colors);
        return $qrCode;
    }

    /**
     * Создание инвайта для участника
     *
     * @param int $managerId
     * @param int $idContest
     * @return Invite
     */
    public static function createInvite(int $managerId, int $contestId): Invite
    {
        $timestamp = Carbon::now()->timestamp;
        $hash = Crypt::encryptString("$timestamp-$managerId-$contestId-contest");

        /* Запись хеша в базу */
        $inviteRequest = new Request();
        $inviteService = new InviteService();

        $inviteRequest->hash = $hash;
        $inviteRequest->contest_id = $contestId;
        $inviteRequest->manager_id = $managerId;

        $invite = $inviteService->create($inviteRequest);

        return $invite;
    }

    /**
     * Генерация уникального кода участника в зависимости от общего количества оных
     *
     * @param int $nextUserId
     * @return int
     */
    public static function generateUniqueCode(int $nextUserId)
    {
        $min = 100;
        $max = 999;

        if ($nextUserId >= 899)
        {
            $min = 1000;
            $max = 9999;
        }
        else if ($nextUserId >= 8999)
        {
            $min = 10000;
            $max = 99999;
        }

        do
        {
            $code = random_int($min, $max);
        }
        while (UserMeta::where('code', '=', $code)->first());

        return intval($code);
    }

    /**
     * Изменение структуры users и заполнение append полей
     *
     * @param  mixed $contest
     * @return
     */
    public static function toParticipants($contest)
    {
        $usersList = $contest->users;
        /* Получение канала из настроек */
        $contestSetting = $contest->settings
            ->firstWhere('key', 'telegram_channel');

        if (!$contestSetting)
        {
            throw new \Exception('Настройка "telegram_channel" не заполнена или ошибочна');
        }

        $tgChannel = $contestSetting->value;

        /* Получение id участников канала в tg */
        $tgUsersInChannel = [];

        if ($tgChannel)
        {
            $tgApi = app(TgApi::class);
            $tgUsersInChannel = $tgApi->getIdsMembersChannel($tgChannel);
        }

        /* Обновление поля participant_telegram модели UserMeta */
        $users = $usersList->each(function($user, $key) use ($tgUsersInChannel)
        {
            $tgUserId = intval($user->meta->telegram_id);
            $isParticipant = in_array($tgUserId, $tgUsersInChannel, true);

            $user->meta
                ->append('participant_telegram')
                ->participant_telegram = $isParticipant ? 1 : 0;

            return $user;
        });

        return $users;
    }

}
