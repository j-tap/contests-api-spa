<?php

namespace App\Http\Controllers\v1;

use App\Services\Company\CompanyService;
use Illuminate\Http\JsonResponse;
use App\Services\Helper\Api;
use App\Http\Requests\Company\CompanyCreateRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Http\Resources\Company\CompanyIndexCollection;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Resources\Setting\SettingShortCollection;

class CompanyController extends Controller
{
    private $companyService;

    /**
     * @param CompanyService $companyService
     */
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = [];
        $companies = $this->companyService->get();
        if ($companies->isNotEmpty()) {
            $result = new CompanyIndexCollection($companies);
        }
        return Api::onSuccess(data: $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CompanyCreateRequest  $request
     * @return JsonResponse
     */
    public function store(CompanyCreateRequest $request): JsonResponse
    {
        $company = $this->companyService->create($request);
        $result = new CompanyResource($company);
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
        $company = $this->companyService->get($id);
        $result = new CompanyResource($company);
        return Api::onSuccess(data: $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompanyUpdateRequest $request
     * @param  int $id
     * @return JsonResponse
     */
    public function update(CompanyUpdateRequest $request, int $id): JsonResponse
    {
        $company = $this->companyService->update($id, $request);
        $result = new CompanyResource($company);
        return Api::onSuccess(data: $result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy (int $id): JsonResponse
    {
        $this->companyService->destroy($id);
        return Api::onSuccess(message: __('message.success'));
    }

}
