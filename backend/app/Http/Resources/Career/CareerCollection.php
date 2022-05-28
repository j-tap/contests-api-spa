<?php

namespace App\Http\Resources\Career;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CareerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return CareerShortResource::collection($this->collection);
    }
}
