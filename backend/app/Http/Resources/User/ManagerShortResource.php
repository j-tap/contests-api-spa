<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Services\Helper\RoleCheck;

class ManagerShortResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $isAdmin = RoleCheck::isAdmin(Auth::user());
        $result = [
            'id' => $this->id,
            'name' => $this->name,
        ];

        if ($isAdmin)
        {
            $result['email'] = $this->email;
            $result['role'] = $this->role;
            $result['companies'] = $this->companies;
        };
        return $result;
    }
}
