<?php

namespace App\Http\Resources\Invite;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Contest\ContestShortResource;
use App\Http\Resources\User\UserShortResource;

class InviteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $contest = new ContestShortResource($this->contest);
        $manager = new UserShortResource($this->manager);
        $user = new UserShortResource($this->user);

        return [
            'id' => $this->id,
            'hash' => $this->hash,
            'active' => $this->active,
            'contest' => $contest,
            'manager' => $manager,
            'user' => $user,
            'created_at' => $this->created_at->toDatetimeString(),
        ];
    }
}
