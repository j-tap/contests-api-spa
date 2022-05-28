<?php

namespace App\Http\Resources\Invite;

use Illuminate\Http\Resources\Json\JsonResource;

class InviteShortResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'hash' => $this->hash,
        ];
    }
}
