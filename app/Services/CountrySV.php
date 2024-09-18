<?php

namespace App\Services;

use App\Models\Continent;
use App\Models\Country;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;


class CountrySV extends BaseService
{
   public function getQuery()
   {
       return Country::query();
   }

   // Get all countries
   public function getAllCountries() 
   {
      $query = $this->getQuery();
      if (isset($query)) {
         $countries = $query->get();
         return $countries;
      } else {
         throw new \Exception('Query not found');
      }
   }

   // Create new country
   public function createNewCountry($params) 
   {
      $country = null;
      $continent_id = $this->getIdByGlobalId(Continent::class, $params['continent_id']);
      if (isset($params)) {
         $country = Country::create([
            'country_name'    => $params['country_name'],
            'profile_picture' => $params['profile_picture'],
            'description'     => $params['description'],
            'continent_id'    => $continent_id,
         ]);
         return $country;
      }
   }

   // Show specific country
   public function getCountryByGlobalId($global_id)
   {
      $country = Country::where('countries.global_id', $global_id)->first();
      if ($country) {
         return $country;
      } else {
         throw new ModelNotFoundException('Country not found');
      }
   }

   // Get countries by course
   public function getCountriesByContinent($continent_id) 
   {
      $continent_id = $this->getIdByGlobalId(Continent::class, $continent_id);
      $countries = Country::where('countries.continent_id', $continent_id)->get();
      if ($countries) {
         return $countries;
      } else {
         throw new ModelNotFoundException('Country not found');
      }
   }

   // Update specific country
   public function updateCountry($params, $global_id)
   {
      $country = Country::where('countries.global_id', $global_id)->first();
      $continent_id = $this->getIdByGlobalId(Continent::class, $params['continent_id']);

      if (isset($country)) {
         if (isset($params)) {
            $country->update([
               'country_name'    => $params['country_name'],
               'profile_picture' => $params['profile_picture'],
               'description'     => $params['description'],
               'continent_id'    => $continent_id,   
            ]);
         } 
         return $country;
      } else {
         throw new ModelNotFoundException('Country not found');
      }
   }

   // Deactivate/Activate country
   public function deactivateCountry($global_id, $active)
   {
      $country = Country::where('countries.global_id', $global_id)->first();
      if (isset($country)) {
         $country->update([
            'active' => $active,
         ]);

         return $country;
      } else {
         throw new ModelNotFoundException('Country not found');
      }
   }
}