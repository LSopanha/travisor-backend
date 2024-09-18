<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
   /**
    * Transform the resource into an array.
    *
    * @return array<string, mixed>
    */
   public function toArray(Request $request): array
   {
      return [
         'global_id'        => $this->global_id,
         'id'               => $this->id,
         'title'               => $this->title,
         'text'               => $this->text,
         'user'             => new UserResource($this->user),
         'destination'      => new DestinationResource($this->destination),
         'comments'         => $this->comments->count(),
         'likes'            => $this->likes->count(),
         'active'           => $this->active,
         'created_at'       => $this->created_at,
         'updated_at'       => $this->updated_at
      ];
   }
}
