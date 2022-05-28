<?php

namespace App\Http\Resources\LandingTemplate;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LandingTemplateCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return LandingTemplateResource::collection($this->collection);
    }
}
