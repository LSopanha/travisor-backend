<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
   /**
    * Transform the resource into an array.
    *
    * @return array<string, mixed>
    */
   public function toArray(Request $request): array
   {
      return [
         'global_id' => $this->global_id,
         'id' => $this->id,
         'first_name' => $this->first_name,
         'last_name' => $this->last_name,
         'dob' => $this->dob,
         'username' => $this->username,
         'gender' => $this->gender,
         'phone' => $this->phone,
         'email' => $this->email,
         'profile_picture' => $this->profile_picture,
         'role' => [
            'global_id' => $this->role->global_id,
            'id' => $this->role->id,
            'role_name' => $this->role->role_name
         ],
         'active' => $this->active,
         'created_at' => $this->created_at,
         'updated_at' => $this->updated_at
      ];
   }
}
