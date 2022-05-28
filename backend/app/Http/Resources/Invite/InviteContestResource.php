<?php

namespace App\Http\Resources\Invite;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Contest\ContestShortResource;
use App\Http\Resources\User\UserShortResource;
use App\Http\Resources\User\ManagerShortResource;

class InviteContestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $manager = new ManagerShortResource($this->manager);
        $user = new UserShortResource($this->user);

        return [
            'id' => $this->id,
            'active' => $this->active,
            'manager' => $manager,
            'user' => $user,
        ];
    }
}
