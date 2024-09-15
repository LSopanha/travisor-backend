<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContinentResource extends JsonResource
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
         'continent_name'  => $this->continent_name,
         'description'     => $this->description,
         'profile_picture' => $this->profile_picture,
         'countries'       => CountryResource::collection($this->countries),
         'country_count'   => $this->countries->count(),
         'active'          => $this->active,
         'created_at'      => $this->created_at,
         'updated_at'      => $this->updated_at
      ];
   }
}
