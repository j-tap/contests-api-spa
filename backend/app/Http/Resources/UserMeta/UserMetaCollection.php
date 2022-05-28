<?php

namespace App\Http\Resources\UserMeta;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserMetaCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return UserMetaResource::collection($this->collection);
    }
}
