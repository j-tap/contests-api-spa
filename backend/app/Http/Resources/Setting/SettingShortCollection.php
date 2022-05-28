<?php

namespace App\Http\Resources\Setting;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SettingShortCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return SettingShortResource::collection($this->collection);
    }
}
