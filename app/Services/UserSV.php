<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;


class UserSV extends BaseService
{
   public function getQuery()
   {
       return User::query();
   }

   // Get all admins
   public function getAllUsers($role) 
   {
      $query = $this->getQuery();
      if (isset($query)) {
          $admins = $query->with('role')->where('role_id', $role)->get();
          return $admins;
      } else {
          throw new \Exception('Query not found');
      }
   }

   // Create new admin
   public function createNewAdmin($params, $role) 
   {
      $admin = null;
      if (isset($params)) {
         $admin = User::create([
            'first_name'      => $params['first_name'],
            'last_name'       => $params['last_name'],
            'username'        => $params['username'],
            'gender'          => $params['gender'],
            'dob'             => $params['dob'],
            'phone'           => $params['phone'],
            'email'           => $params['email'],
            'password'        => $params['password'],
            'profile_picture' => $params['profile_picture'],
            'role_id'         => $role,
         ]);
         return $admin;
      }
   }

   // Show specific admin
   public function getUserByGlobalId($global_id)
   {
      $admin = User::where('users.global_id', $global_id)->first();
      if ($admin) {
         return $admin;
      } else {
         throw new ModelNotFoundException('Admin not found');
      }
   }

   // Update specific admin
   public function updateUser($params, $global_id)
   {
      $admin = User::where('users.global_id', $global_id)->first();

      if (isset($admin)) {
         $currentAdmin = User::where('global_id', $global_id)->first();
         $existingAdmin = User::where('email', $params['email'])->first();
         if ($existingAdmin && $currentAdmin->email != $params['email']) {
            throw new ModelNotFoundException('Email already exists');
         } else {
            if (isset($params['password']) && isset($params['email'])) {
                  $admin->update([
                  'first_name' => $params['first_name'] ?? $admin->first_name,
                  'last_name' => $params['last_name'] ?? $admin->last_name,
                  'username' => $params['username'] ?? $admin->username,
                  'gender' => $params['gender'] ?? $admin->gender,
                  'dob' => $params['dob'] ?? $admin->dob,
                  'phone' => $params['phone'] ?? $admin->phone,
                  'email' => $params['email'] ?? $admin->email,
                  'password' => $params['password'],
                  'profile_picture' => $params['profile_picture'] ?? $admin->profile_picture,
               ]);
            } elseif (isset($params['password']) && !isset($params['email'])) {
                  $admin->update([
                  'first_name' => $params['first_name'] ?? $admin->first_name,
                  'last_name' => $params['last_name'] ?? $admin->last_name,
                  'username' => $params['username'] ?? $admin->username,
                  'gender' => $params['gender'] ?? $admin->gender,
                  'dob' => $params['dob'] ?? $admin->dob,
                  'phone' => $params['phone'] ?? $admin->phone,
                  'password' => $params['password'],
                  'profile_picture' => $params['profile_picture'] ?? $admin->profile_picture,
               ]);
            } elseif (!isset($params['password']) && isset($params['email'])) {
                  $admin->update([
                  'first_name' => $params['first_name'] ?? $admin->first_name,
                  'last_name' => $params['last_name'] ?? $admin->last_name,
                  'username' => $params['username'] ?? $admin->username,
                  'gender' => $params['gender'] ?? $admin->gender,
                  'dob' => $params['dob'] ?? $admin->dob,
                  'phone' => $params['phone'] ?? $admin->phone,
                  'email' => $params['email'] ?? $admin->email,
                  'profile_picture' => $params['profile_picture'] ?? $admin->profile_picture,
               ]);
            } elseif (!isset($params['email']) && !isset($params['password'])) {
                  $admin->update([
                  'first_name' => $params['first_name'] ?? $admin->first_name,
                  'last_name' => $params['last_name'] ?? $admin->last_name,
                  'username' => $params['username'] ?? $admin->username,
                  'gender' => $params['gender'] ?? $admin->gender,
                  'dob' => $params['dob'] ?? $admin->dob,
                  'phone' => $params['phone'] ?? $admin->phone,
                  'profile_picture' => $params['profile_picture'] ?? $admin->profile_picture,
               ]);
            }
         }

         return $admin;
      } else {
         throw new ModelNotFoundException('Admin not found');
      }
   }

   // Deactivate/Activate admin
   public function deactivateUser($global_id, $active)
   {
       $admin = User::where('users.global_id', $global_id)->first();
       if (isset($admin)) {
           $admin->update([
               'active' => $active,
           ]);

           return $admin;
       } else {
           throw new ModelNotFoundException('Admin not found');
       }
   }
}