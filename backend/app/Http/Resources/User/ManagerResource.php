<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Company\CompanyCollection;

class ManagerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $invites = $this->invites;
        $statistic = [
            'invites_count' => $invites->count(),
            'participants_count' => $invites->whereNotNull('user_id')->count(),
            'contest_count' => $invites->unique('contest_id')->pluck('contest_id')->count(),
        ];
        $companies = new CompanyCollection($this->companies);

        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'role' => $this->role,
            'companies' => $companies,
            'statistic' => $statistic,
        ];
    }
}
