<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Company\CompanyCollection;
use App\Http\Resources\UserMeta\UserMetaResource;

class UserResource extends JsonResource
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
        // $invite = $this->invite();
        $companies = new CompanyCollection($this->companies);

        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'role' => $this->role,
            'companies' => $companies,
            'meta' => $meta,
            'created_at' => $this->created_at->toDatetimeString(),
            // 'invite' => $invite,
        ];
    }
}
