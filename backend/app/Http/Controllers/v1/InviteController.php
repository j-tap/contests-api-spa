<?php

namespace App\Http\Controllers\v1;

use App\Services\Invite\InviteService;
use Illuminate\Http\JsonResponse;
use App\Services\Helper\Api;
use App\Http\Resources\Invite\InviteCollection;
use App\Http\Resources\Invite\InviteResource;
use App\Http\Requests\Invite\InviteCreateRequest;
use App\Http\Requests\Invite\InviteUpdateRequest;

class InviteController extends Controller
{
    private $inviteService;

    /**
     * @param InviteService $inviteService
     */
    public function __construct(InviteService $inviteService)
    {
        $this->inviteService = $inviteService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = [];
        $invites = $this->inviteService->get();
        if ($invites->isNotEmpty()) {
            $result = new InviteCollection($invites);
        }
        return Api::onSuccess(data: $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  InviteCreateRequest $request
     * @return JsonResponse
     */
    public function store(InviteCreateRequest $request): JsonResponse
    {
        $invite = $this->inviteService->create($request);
        $result = new InviteResource($invite);
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
        $invite = $this->inviteService->get($id);
        $result = new InviteResource($invite);
        return Api::onSuccess(data: $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  InviteUpdateRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(InviteUpdateRequest $request, $id): JsonResponse
    {
        $invite = $this->inviteService->update($id, $request);
        $result = new InviteResource($invite);
        return Api::onSuccess(data: $result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $this->inviteService->destroy($id);
        return Api::onSuccess(message: __('message.success'));
    }
}
