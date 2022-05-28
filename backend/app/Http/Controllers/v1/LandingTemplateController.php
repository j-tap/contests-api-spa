<?php

namespace App\Http\Controllers\v1;

use App\Services\LandingTemplate\LandingTemplateService;
use Illuminate\Http\JsonResponse;
use App\Services\Helper\Api;
use App\Http\Requests\LandingTemplate\LandingTemplateCreateRequest;
use App\Http\Requests\LandingTemplate\LandingTemplateUpdateRequest;
use App\Http\Resources\LandingTemplate\LandingTemplateCollection;
use App\Http\Resources\LandingTemplate\LandingTemplateResource;

class LandingTemplateController extends Controller
{
    private $landingTemplateService;

    /**
     * @param LandingTemplateService $landingTemplateService
     */
    public function __construct(LandingTemplateService $landingTemplateService)
    {
        $this->landingTemplateService = $landingTemplateService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = [];
        $landingTemplates = $this->landingTemplateService->get();
        if ($landingTemplates->isNotEmpty()) {
            $result = new LandingTemplateCollection($landingTemplates);
        }
        return Api::onSuccess(data: $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LandingTemplateCreateRequest  $request
     * @return JsonResponse
     */
    public function store(LandingTemplateCreateRequest $request): JsonResponse
    {
        $landingTemplate = $this->landingTemplateService->create($request);
        $result = new LandingTemplateResource($landingTemplate);
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
        $landingTemplate = $this->landingTemplateService->get($id);
        $result = new LandingTemplateResource($landingTemplate);
        return Api::onSuccess(data: $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LandingTemplateUpdateRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(LandingTemplateUpdateRequest $request, int $id): JsonResponse
    {
        $landingTemplate = $this->landingTemplateService->update($id, $request);
        $result = new LandingTemplateResource($landingTemplate);
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
        $this->landingTemplateService->destroy($id);
        return Api::onSuccess(message: __('message.success'));
    }
}
