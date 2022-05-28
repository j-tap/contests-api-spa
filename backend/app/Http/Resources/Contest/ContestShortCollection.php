<?php

namespace App\Http\Resources\Contest;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ContestShortCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ContestShortResource::collection($this->collection);
    }
}
