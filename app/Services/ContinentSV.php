<?php

namespace App\Services;

use App\Models\Continent;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;


class ContinentSV extends BaseService
{
   public function getQuery()
   {
       return Continent::query();
   }

   // Get all continents
   public function getAllContinents() 
   {
      $query = $this->getQuery();
      if (isset($query)) {
          $continents = $query->get();
          return $continents;
      } else {
          throw new \Exception('Query not found');
      }
   }

   // Create new continent
   public function createNewContinent($params) 
   {
      $continent = null;
      if (isset($params)) {
         $continent = Continent::create([
            'continent_name'  => $params['continent_name'],
            'profile_picture' => $params['profile_picture'],
            'description'     => $params['description'],
         ]);
         return $continent;
      }
   }

   // Show specific continent
   public function getContinentByGlobalId($global_id)
   {
      $continent = Continent::where('continents.global_id', $global_id)->first();
      if ($continent) {
         return $continent;
      } else {
         throw new ModelNotFoundException('Continent not found');
      }
   }

   // Update specific continent
   public function updateContinent($params, $global_id)
   {
      $continent = Continent::where('continents.global_id', $global_id)->first();

      if (isset($continent)) {
         if (isset($params)) {
            $continent->update([
               'continent_name'  => $params['continent_name'],
               'profile_picture' => $params['profile_picture'],
               'description'     => $params['description'],
            ]);
         } 
         
         return $continent;
      } else {
         throw new ModelNotFoundException('Continent not found');
      }
   }

   // Deactivate/Activate continent
   public function deactivateContinent($global_id, $active)
   {
      $continent = Continent::where('continents.global_id', $global_id)->first();
      if (isset($continent)) {
         $continent->update([
            'active' => $active,
         ]);

         return $continent;
      } else {
         throw new ModelNotFoundException('Continent not found');
      }
   }
}