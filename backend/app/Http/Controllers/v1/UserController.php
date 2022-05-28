<?php

namespace App\Http\Controllers\v1;

use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use App\Services\Helper\Api;
use App\Http\Resources\User\ManagerCollection;
use App\Http\Resources\User\ManagerResource;
use App\Http\Resources\User\ParticipantsResource;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\User\ParticipantUpdateRequest;

class UserController extends Controller
{
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index (): JsonResponse
    {
        $result = [];
        $users = $this->userService->get();
        if ($users->isNotEmpty()) {
            $result = new ManagerCollection($users);
        }
        return Api::onSuccess(data: $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserUpdateRequest $request
     * @return JsonResponse
     */
    public function store (UserCreateRequest $request): JsonResponse
    {
        $user = $this->userService->create($request);
        $result = new ManagerResource($user);
        return Api::onSuccess(data: $result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show (int $id): JsonResponse
    {
        $user = $this->userService->get($id);
        $result = new ManagerResource($user);
        return Api::onSuccess(data: $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest $request
     * @param  int $id
     * @return JsonResponse
     */
    public function update (UserUpdateRequest $request, int $id): JsonResponse
    {
        $user = $this->userService->update($id, $request);
        $result = new ManagerResource($user);
        return Api::onSuccess(data: $result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    {
        $this->userService->destroy($id);
        return Api::onSuccess(message: __('message.success'));
    }

    /**
     * Установка участника как победитель
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function winner (int $id): JsonResponse
    {
        $user = $this->userService->setWinner($id);
        $result = new ParticipantsResource($user);
        return Api::onSuccess(data: $result);
    }

    /**
     * Обновлении полей участника
     *
     * @param  ParticipantUpdateRequest $request
     * @param  int $id
     * @return JsonResponse
     */
    public function participantUpdate (ParticipantUpdateRequest $request, int $id): JsonResponse
    {
        $user = $this->userService->participantUpdate($id, $request);
        $result = new ParticipantsResource($user);
        return Api::onSuccess(data: $result);
    }
}
