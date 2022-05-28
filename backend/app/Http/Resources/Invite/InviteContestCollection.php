<?php

namespace App\Http\Resources\Invite;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InviteContestCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return InviteContestResource::collection($this->collection);
    }
}
