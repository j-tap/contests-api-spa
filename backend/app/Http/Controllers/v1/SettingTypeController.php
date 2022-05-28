<?php

namespace App\Http\Controllers\v1;

use App\Services\SettingType\SettingTypeService;
use Illuminate\Http\JsonResponse;
use App\Services\Helper\Api;
use App\Http\Requests\Setting\SettingCreateRequest;
use App\Http\Requests\Setting\SettingUpdateRequest;
use App\Http\Resources\Setting\SettingCollection;
use App\Http\Resources\Setting\SettingResource;

class SettingTypeController extends Controller
{
    private $settingTypeService;

    /**
     * @param SettingTypeService $settingTypeService
     */
    public function __construct(SettingTypeService $settingTypeService)
    {
        $this->settingTypeService = $settingTypeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = [];
        $settingsTypes = $this->settingTypeService->get();
        if ($settingsTypes->isNotEmpty()) {
            $result = new SettingCollection($settingsTypes);
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
        $settingType = $this->settingTypeService->create($request);
        $result = new SettingResource($settingType);
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
        $settingType = $this->settingTypeService->get($id);
        $result = new SettingResource($settingType);
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
        $settingType = $this->settingTypeService->update($id, $request);
        $result = new SettingResource($settingType);
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
        $this->settingTypeService->destroy($id);
        return Api::onSuccess(message: __('message.success'));
    }
}
