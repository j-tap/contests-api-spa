<?php

namespace App\Http\Resources\Contest;

use Illuminate\Http\Resources\Json\JsonResource;

class ContestPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $settings = $this->contest->settings;
        $telegram_channel = $settings->where('key', 'telegram_channel')->first();
        $channel = $telegram_channel->value;

        $result = [
            'invite' => [
                'active' => $this->invite->active,
            ],
            'active' => $this->contest->active,
            'status' => $this->contest->status->id,
            'date' => [
                'from' => $this->contest->date_from,
                'to' => $this->contest->date_to,
            ],
            'landing_template' => $this->contest->landingTemplate->key,
            'channel' => $channel,
        ];

        if ($this->careers)
        {
            $result['careers'] = $this->careers;
        }

        return $result;
    }
}
