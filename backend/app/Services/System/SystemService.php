<?php

namespace App\Services\System;

use App\Services\BaseControllerService;
use Carbon\Carbon;
use App\Models\Setting;
use App\Services\Tg\TgApi;

class SystemService extends BaseControllerService
{
    private $settingPhoneKey = 'telegram_login_phone';

    /**
     * Получение логов
     *
     * @return Array
     */
    public function log(): Array
    {
        $result = [];
        $fileLog = storage_path('logs/laravel.log');

        if (file_exists($fileLog))
        {
            $content = file_get_contents($fileLog);
            $pattern = "/^\[(?<date>.*)\]\s(?<env>\w+)\.(?<type>\w+):(?<message>.*)/m";
            preg_match_all($pattern, $content, $matches, PREG_SET_ORDER, 0);

            foreach ($matches as $match)
            {
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $match['date']); // ->setTimezone(config('app.show_timezone'))
                $result[] = [
                    'date' => $date,
                    'env' => $match['env'],
                    'type' => $match['type'],
                    'message' => trim($match['message'])
                ];
            }
        }

        return array_reverse($result);
    }

    /**
     * Статус авторизации Telegram
     *
     * @return array
     */
    public function tgStatus(): array
    {
        $tgApi = app(TgApi::class);
        $setting = Setting::firstWhere('key', $this->settingPhoneKey);
        $result = [];

        $result['setting_key'] = $setting->key;
        $result['phone'] = $setting->value;
        $result['is_logged'] = $tgApi->isLoggedIn();
        return $result;
    }

    /**
     * Автортзация в Telegram
     *
     * @return mixed
     */
    public function tgAuth($request)
    {
        $tgApi = app(TgApi::class);

        if (isset($request->code))
        {
            $result = $tgApi->checkVerificationCode($request->code);
        }
        else {
            $setting = Setting::firstWhere('key', $this->settingPhoneKey);
            $result = $tgApi->sendVerificationCode($setting->value);
        }
        return $result;
    }

    /**
     * Очистка сессии Telegram
     *
     * @return mixed
     */
    public function tgLogout()
    {
        $tgApi = app(TgApi::class);
        return $tgApi->logout();
    }

}
