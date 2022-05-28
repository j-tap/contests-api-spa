<?php

namespace App\Http\Resources\Contest;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Status\StatusResource;
use App\Http\Resources\Company\CompanyShortResource;

class ContestShortResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $status = new StatusResource($this->status);
        $company = new CompanyShortResource($this->company);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'active' => $this->active,
            'status' => $status,
            'date' => [
                'from' => $this->date_from,
                'to' => $this->date_to,
            ],
            'company' => $company,
        ];
    }
}
