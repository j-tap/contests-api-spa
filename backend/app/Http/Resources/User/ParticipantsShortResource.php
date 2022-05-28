<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserMeta\UserMetaResource;

class ParticipantsShortResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $meta = new UserMetaResource($this->meta);

        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'meta' => $meta,
        ];
    }
}
