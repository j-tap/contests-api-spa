<?php

namespace App\Http\Resources\UserMeta;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\ManagerShortResource;

class UserMetaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = $this->user;
        $invite = $user->invite;
        $manager = new ManagerShortResource($invite->manager);

        return [
            'code' => $this->code,
            'telegram_id' => $this->telegram_id,
            'telegram' => $this->telegram,
            'career' => $this->career,
            'comment' => $this->comment,
            'winner' => $this->winner,
            'order_winner' => $this->order_winner,
            'participant_telegram' => $this->participant_telegram,
            'manager' => $manager,
            'created_at_qr' => $invite->created_at->toDatetimeString(),
        ];
    }
}
