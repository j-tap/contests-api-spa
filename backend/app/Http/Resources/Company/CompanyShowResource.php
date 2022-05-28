<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $contestsData = $this->contests()->get();
        $contestsActive = $contestsData->filter(function ($item)
        {
            return $item->active;
        });
        $countContestsAll = $contestsData->count();
        $countContestsActive = $contestsActive->count();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'contests_count' => [
                'active' => $countContestsActive,
                'all' => $countContestsAll,
            ],
        ];
    }
}
