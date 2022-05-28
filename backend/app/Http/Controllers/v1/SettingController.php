<?php

namespace App\Http\Controllers\v1;

use App\Services\Setting\SettingService;
use Illuminate\Http\JsonResponse;
use App\Services\Helper\Api;
use App\Http\Requests\Setting\SettingCreateRequest;
use App\Http\Requests\Setting\SettingUpdateRequest;
use App\Http\Requests\Setting\SettingUpdateMultipleRequest;
use App\Http\Resources\Setting\SettingCollection;
use App\Http\Resources\Setting\SettingResource;

class SettingController extends Controller
{
    private $settingService;

    /**
     * @param SettingService $settingService
     */
    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = [];
        $settings = $this->settingService->get();
        if ($settings->isNotEmpty()) {
            $result = new SettingCollection($settings);
        }
        return Api::onSuccess(data: $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SettingCreateRequest $request
     * @return JsonResponse
     */
    public function store(SettingCreateRequest $request): JsonResponse
    {
        $setting = $this->settingService->create($request);
        $result = new SettingResource($setting);
        return Api::onSuccess(data: $result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $setting = $this->settingService->get($id);
        $result = new SettingResource($setting);
        return Api::onSuccess(data: $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SettingUpdateRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(SettingUpdateRequest $request, int $id): JsonResponse
    {
        $setting = $this->settingService->update($id, $request);
        $result = new SettingResource($setting);
        return Api::onSuccess(data: $result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->settingService->destroy($id);
        return Api::onSuccess(message: __('message.success'));
    }

    /**
     * Обновление массива настроек
     *
     * @param  SettingUpdateMultipleRequest $request
     * @return JsonResponse
     */
    public function updateMultiple(SettingUpdateMultipleRequest $request): JsonResponse
    {
        $settings = $this->settingService->updateMultiple($request);
        $result = new SettingCollection($settings);
        return Api::onSuccess(data: $result);
    }

}
