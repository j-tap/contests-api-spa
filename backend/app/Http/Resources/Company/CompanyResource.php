<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\UserShortCollection;
use App\Http\Resources\Contest\ContestShortCollection;
use App\Http\Resources\Setting\SettingEntityCollection;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $settingsCollection = new SettingEntityCollection($this->settings);
        $usersCollection = new UserShortCollection($this->users);
        $contestsCollection = new ContestShortCollection($this->contests);
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
            'users' => $usersCollection,
            'contests' => $contestsCollection,
            'settings' => $settingsCollection,
            'contests_count' => [
                'active' => $countContestsActive,
                'all' => $countContestsAll,
            ],
        ];
    }
}
