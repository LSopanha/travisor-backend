<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
   /**
    * Transform the resource into an array.
    *
    * @return array<string, mixed>
    */
   public function toArray(Request $request): array
   {
      return [
         'global_id'       => $this->global_id,
         'id'              => $this->id,
         'country_name'    => $this->country_name,
         'description'     => $this->description,
         'profile_picture' => $this->profile_picture,
         'continent'       => [
            'global_id'      => $this->continent->global_id,
            'continent_name' => $this->continent->continent_name,
            'description'    => $this->continent->description
         ],
         'active'     => $this->active,
         'created_at' => $this->created_at,
         'updated_at' => $this->updated_at
      ];
   }
}
