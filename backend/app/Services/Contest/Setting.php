<?php

namespace App\Services\Contest;

use Illuminate\Http\Request;
use App\Services\Setting\SettingService;

class Setting
{
    /**
     * Создание настроек для розыгрыша
     *
     * @param int $companyId
     * @param int $contestId
     * @return void
     */
    public static function createSettings (int $companyId, int $contestId): Array
    {
        $settingService = new SettingService();
        $rows = [
            [
                'name' => 'Telegram канал',
                'key' => 'telegram_channel',
                'value' => null,
                'setting_type_id' => 1,
                'company_id' => null,
                'contest_id' => $contestId,
                'description' => 'Telegram канал на который ведут ссылки и в котором ведётся поиск участников',
            ],
            [
                'name' => 'URL лендинга',
                'key' => 'landing_url',
                'value' => null,
                'setting_type_id' => 1,
                'company_id' => null,
                'contest_id' => $contestId,
                'description' => 'Адрес домена, на котором размещена форма регистрации и описание розыгрыша',
            ],
        ];

        $result = [];

        foreach ($rows as $i => $row)
        {
            $result[$i] = new Request();
            foreach ($row as $key => $val)
            {
                $result[$i]->{$key} = $val;
            }
            $settingService->create($result[$i]);
        }
        return $result;
    }

}
