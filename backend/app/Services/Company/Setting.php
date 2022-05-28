<?php

namespace App\Services\Company;

use Illuminate\Http\Request;
use App\Services\Setting\SettingService;

class Setting
{
    /**
     * Создание настроек для компании
     *
     * @param int $companyId
     * @return void
     */
    public static function createSettings (int $companyId): Array
    {
        $settingService = new SettingService();
        $rows = [
            [
                'name' => 'Цвета компании',
                'key' => 'company_colors',
                'value' => '#707070, #222222',
                'setting_type_id' => 1,
                'company_id' => $companyId,
                'contest_id' => null,
                'description' => 'Два базовых цвета компании для QR',
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
