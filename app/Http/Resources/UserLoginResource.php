<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'status' => 'Success',
            'id' => $this->id,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'token' => $this->token
        ];
    }
}
