<?php

namespace App\Http\Controllers\v1;

use App\Services\Career\CareerService;
use Illuminate\Http\JsonResponse;
use App\Services\Helper\Api;
use App\Http\Requests\Career\CareerCreateRequest;
use App\Http\Requests\Career\CareerUpdateRequest;
use App\Http\Resources\Career\CareerCollection;
use App\Http\Resources\Career\CareerResource;

class CareerController extends Controller
{
    private $careerService;

    /**
     * @param CareerService $careerService
     */
    public function __construct(CareerService $careerService)
    {
        $this->careerService = $careerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = [];
        $careers = $this->careerService->get();
        if ($careers->isNotEmpty()) {
            $result = new CareerCollection($careers);
        }
        return Api::onSuccess(data: $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CareerCreateRequest $request
     * @return JsonResponse
     */
    public function store(CareerCreateRequest $request): JsonResponse
    {
        $career = $this->careerService->create($request);
        $result = new CareerResource($career);
        return Api::onSuccess(data: $result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $career = $this->careerService->get($id);
        $result = new CareerResource($career);
        return Api::onSuccess(data: $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CareerUpdateRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(CareerUpdateRequest $request, int $id): JsonResponse
    {
        $career = $this->careerService->update($id, $request);
        $result = new CareerResource($career);
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
        $this->careerService->destroy($id);
        return Api::onSuccess(message: __('message.success'));
    }
}
