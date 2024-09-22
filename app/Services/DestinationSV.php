<?php

namespace App\Services;

use App\Models\Continent;
use App\Models\Country;
use App\Models\Destination;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;


class DestinationSV extends BaseService
{
   public function getQuery()
   {
       return Destination::query();
   }

   // Get all destinations
   public function getAllDestinations() 
   {
      $query = $this->getQuery();
      if (isset($query)) {
         $destinations = $query->get();
         return $destinations;
      } else {
         throw new \Exception('Query not found');
      }
   }

   // Create new destination
   public function createNewDestination($params) 
   {
      $destination  = null;
      $continent_id = $this->getIdByGlobalId(Continent::class, $params['continent_id']);
      $country_id   = $this->getIdByGlobalId(Country::class, $params['country_id']);

      if (isset($params)) {
         $destination = Destination::create([
            'destination_name' => $params['destination_name'],
            'description'      => $params['description'],
            'profile_picture'  => $params['profile_picture'],
            'continent_id'     => $continent_id,
            'country_id'       => $country_id,
         ]);
         return $destination;
      }
   }

   // Show specific destination
   public function getDestinationByGlobalId($global_id)
   {
      $destination = Destination::where('destinations.global_id', $global_id)->first();
      if ($destination) {
         return $destination;
      } else {
         throw new ModelNotFoundException('Destination not found');
      }
   }

      // Show specific destination
      public function getDestinationByCountry($global_id)
      {
         $country_id   = $this->getIdByGlobalId(Country::class, $global_id);
         $destinations = Destination::where('destinations.country_id', $country_id)->get();
         if ($destinations) {
            return $destinations;
         } else {
            throw new ModelNotFoundException('Destination not found');
         }
      }

   // Update specific destination
   public function updateDestination($params, $global_id)
   {
      $destination  = Destination::where('destinations.global_id', $global_id)->first();
      $continent_id = $this->getIdByGlobalId(Continent::class, $params['continent_id']);
      $country_id   = $this->getIdByGlobalId(Country::class, $params['country_id']);

      if (isset($destination)) {
         if (isset($params)) {
            $destination->update([
               'destination_name' => $params['destination_name'],
               'description'      => $params['description'],
               'profile_picture'  => $params['profile_picture'],
               'continent_id'     => $continent_id,
               'country_id'       => $country_id,
            ]);
         } 
         return $destination;
      } else {
         throw new ModelNotFoundException('Destination not found');
      }
   }

   // Deactivate/Activate destination
   public function deactivateDestination($global_id, $active)
   {
      $destination = Destination::where('destinations.global_id', $global_id)->first();
      if (isset($destination)) {
         $destination->update([
            'active' => $active,
         ]);
         return $destination;
      } else {
         throw new ModelNotFoundException('Destination not found');
      }
   }
}