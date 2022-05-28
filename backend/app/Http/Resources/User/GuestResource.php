<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserMeta\UserMetaResource;

class GuestResource extends JsonResource
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
            'email' => $this->email,
            'name' => $this->name,
            'code' => $meta->code,
            'telegram' => $meta->telegram,
            'career' => $meta->career,
        ];
    }
}
