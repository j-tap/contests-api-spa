<?php

namespace App\Http\Resources\Setting;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingEntityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $settingType = $this->settingType;
        return [
            'id' => $this->id,
            'key' => $this->key,
            'value' => $this->value,
            'name' => $this->name,
            'description' => $this->description,
            'setting_type' => $settingType,
        ];
    }
}
