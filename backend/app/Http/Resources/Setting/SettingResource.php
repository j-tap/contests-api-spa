<?php

namespace App\Http\Resources\Setting;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Company\CompanyShortResource;
use App\Http\Resources\Contest\ContestShortResource;

class SettingResource extends JsonResource
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
        $company = new CompanyShortResource($this->company);
        $contest = new ContestShortResource($this->contest);

        return [
            'id' => $this->id,
            'key' => $this->key,
            'value' => $this->value,
            'name' => $this->name,
            'description' => $this->description,
            'setting_type' => $settingType,
            'contest' => $contest,
            'company' => $company,
        ];
    }
}
