<?php

namespace App\Http\Controllers\v1;

use App\Services\Contest\ContestService;
use App\Services\Helper\Api;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Contest\RegistrationRequest;
use App\Http\Requests\Contest\ContestCreateRequest;
use App\Http\Requests\Contest\ContestUpdateRequest;
use App\Http\Requests\Contest\ContestQrRequest;
use App\Http\Resources\Contest\ContestCollection;
use App\Http\Resources\Contest\ContestResource;
use App\Http\Resources\Contest\ContestPublicResource;
use App\Http\Resources\User\ParticipantsShortCollection;
use App\Http\Resources\User\GuestResource;

class ContestController extends Controller
{

    private $contestService;

    /**
     * @param ContestService $contestService
     */
    public function __construct(ContestService $contestService)
    {
        $this->contestService = $contestService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = [];
        $contests = $this->contestService->get();
        if ($contests->isNotEmpty()) {
            $result = new ContestCollection($contests);
        }
        return Api::onSuccess(data: $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ContestCreateRequest $request
     * @return JsonResponse
     */
    public function store(ContestCreateRequest $request): JsonResponse
    {
        $contest = $this->contestService->create($request);
        $result = new ContestResource($contest);
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
        $contest = $this->contestService->get($id);
        $result = new ContestResource($contest);
        return Api::onSuccess(data: $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ContestUpdateRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(ContestUpdateRequest $request, int $id): JsonResponse
    {
        $contest = $this->contestService->update($id, $request);
        $result = new ContestResource($contest);
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
        $this->contestService->destroy($id);
        return Api::onSuccess(message: __('message.success'));
    }

    /**
     * Регистрация нового участника
     *
     * @param  RegistrationRequest $request
     * @return JsonResponse
     */
    public function registration(RegistrationRequest $request): JsonResponse
    {
        $user = $this->contestService->registrationUser($request);
        $result = new GuestResource($user);
        return Api::onSuccess(data: $result);
    }

    /**
     * Получение QR кода для участия
     *
     * @param ContestQrRequest $request
     * @return JsonResponse
     */
    public function qr(ContestQrRequest $request): JsonResponse
    {
        $result = $this->contestService->qrCode($request);
        return Api::onSuccess(data: $result);
    }

    /**
     * Получение информации по хешу
     *
     * @param string $hash
     * @return JsonResponse
     */
    public function infoByHash(string $hash): JsonResponse
    {
        $contest = $this->contestService->infoByHash($hash);
        $result = new ContestPublicResource($contest);
        return Api::onSuccess(data: $result);
    }

    /**
     * Получение кодов и id участников
     *
     * @param int $id
     * @return JsonResponse
     */
    public function participants(int $id): JsonResponse
    {
        $users = $this->contestService->getParticipants($id);
        $result = new ParticipantsShortCollection($users);
        return Api::onSuccess(data: $result);
    }

}
