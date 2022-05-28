<?php

namespace App\Http\Controllers\v1;

use App\Services\Status\StatusService;
use Illuminate\Http\JsonResponse;
use App\Services\Helper\Api;
use App\Http\Resources\Status\StatusCollection;
use App\Http\Resources\Status\StatusResource;

class StatusController extends Controller
{
    private $statusService;

    /**
     * @param StatusService $statusService
     */
    public function __construct(StatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = [];
        $statuses = $this->statusService->get();
        if ($statuses->isNotEmpty()) {
            $result = new StatusCollection($statuses);
        }
        return Api::onSuccess(data: $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return JsonResponse
     */
    public function store($request): JsonResponse
    {
        $status = $this->statusService->create($request);
        $result = new StatusResource($status);
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
        $status = $this->statusService->get($id);
        $result = new StatusResource($status);
        return Api::onSuccess(data: $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update($request, int $id): JsonResponse
    {
        $status = $this->statusService->update($id, $request);
        $result = new StatusResource($status);
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
        $this->statusService->destroy($id);
        return Api::onSuccess(message: __('message.success'));
    }
}
