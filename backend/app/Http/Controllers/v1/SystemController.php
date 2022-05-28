<?php

namespace App\Http\Controllers\v1;

use App\Services\System\SystemService;
use Illuminate\Http\JsonResponse;
use App\Services\Helper\Api;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    private $systemService;

    /**
     * @param SystemService $systemService
     */
    public function __construct(SystemService $systemService)
    {
        $this->systemService = $systemService;
    }

    /**
     * Логи
     *
     * @return JsonResponse
     */
    public function log(): JsonResponse
    {
        $result = $this->systemService->log();
        return Api::onSuccess(data: $result);
    }

    /**
     * Авторизация в Telegram
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function tgAuth(Request $request): JsonResponse
    {
        $result = $this->systemService->tgAuth($request);
        return Api::onSuccess(data: $result);
    }

    /**
     * Очистка сессии Telegram
     *
     * @return JsonResponse
     */
    public function tgLogout(): JsonResponse
    {
        $result = $this->systemService->tgLogout();
        return Api::onSuccess(data: $result);
    }

    /**
     * Статус авторизации Telegram
     *
     * @return JsonResponse
     */
    public function tgStatus(): JsonResponse
    {
        $result = $this->systemService->tgStatus();
        return Api::onSuccess(data: $result);
    }

}
