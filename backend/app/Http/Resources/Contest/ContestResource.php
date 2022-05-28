<?php

namespace App\Http\Resources\Contest;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Company\CompanyShortResource;
use App\Http\Resources\Status\StatusResource;
use App\Http\Resources\Invite\InviteContestCollection;
use App\Http\Resources\User\ParticipantsCollection;
use App\Http\Resources\Setting\SettingEntityCollection;

class ContestResource extends JsonResource
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
        $company = new CompanyShortResource($this->company);
        $invitesCollection = new InviteContestCollection($this->invites);
        $participantsCollection = new ParticipantsCollection($this->users);
        $status = new StatusResource($this->status);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'active' => $this->active,
            'status' => $status,
            'date' => [
                'from' => $this->date_from,
                'to' => $this->date_to,
            ],
            'landing_template' => $this->landingTemplate,
            'company' => $company,
            'invites' => $invitesCollection,
            'participants' => $participantsCollection,
            'settings' => $settingsCollection,
        ];
    }
}
