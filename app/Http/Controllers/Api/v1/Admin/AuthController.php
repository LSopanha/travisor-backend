<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\BaseAPI;
use App\Models\User;
use App\Services\AuthSV;

class AuthController extends BaseAPI
{
   protected $authSV;
   public function __construct() {
      $this->authSV = new AuthSV();
   }

   // User authentication when logging in
   public function loginAuthentication()
   {
      $credentials = request(['email', 'password']);
      $userData = User::where('email', request('email'))->first();
   
      return $this->authSV->loginAdmin($credentials, $userData);
   }

   // Get current user information
   public function userInformation() 
   {
      return $this->authSV->GetProfileAdmin();
      
   }

   // Logged out
   public function logout()
   {
      return $this->authSV->logoutAdmin();
   }

   // Generate new token when access token expired
   public function tokenRefresh()
   {
      return $this->authSV->refreshAdmin();
   }
}