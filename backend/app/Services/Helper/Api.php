<?php

namespace App\Services\Helper;

use Illuminate\Http\JsonResponse;
use DateTime;

class Api
{
    private static $format = [
        'success' => true,
        'status' => null,
        'message' => null,
        'timestamp' => null,
        'data' => null,
        'errors' => null,
    ];

    /**
     * Формирование успешного ответа
     *
     * @param  int $code
     * @param  string $message
     * @param  mixed $data
     * @return JsonResponse
     */
    static function onSuccess(int $code = 200, string $message = null, $data = null): JsonResponse
    {
        $data = [
            'success' => true,
            'data' => $data,
            'status' => $code,
            'message' => $message,
        ];
        return self::onRequest($data, $code);
    }

    /**
     * Формирование ответа ошибки
     *
     * @param  int $code
     * @param  string $message
     * @param  mixed $error
     * @return JsonResponse
     */
    static function onError(int $code = 400, string $message = null, $errors = null, $info = []): JsonResponse
    {
        $data = [
            'success' => false,
            'errors' => $errors,
            'status' => $code,
            'message' => $message,
        ];
        if (config('app.debug')) {
            $data['info'] = $info;
        }
        return self::onRequest($data, $code);
    }

    /**
     * Обёртка для формирования ответа
     *
     * @param  mixed $data
     * @param  mixed $code
     * @return JsonResponse
     */
    private static function onRequest(array $data, int $code): JsonResponse
    {
        $now = new DateTime();
        $data['timestamp'] = $now->getTimestamp();

        return response()->json(array_merge(self::$format, $data), $code, [], JSON_UNESCAPED_UNICODE);
    }

}
