<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;


class AuthSV extends BaseService
{
   /**
   * Get a JWT via given credentials.
   *
   * @return \Illuminate\Http\JsonResponse
   */
   public function loginAdmin($credentials, $userData)
   {
      if (!$credentials) {
         return response()->json(['error' => 'Invalid credentials'], 401);
      }

      $user = User::where('email', $credentials['email'])->first();
      $isDeactivated = $user->active;
      if (!$user) { //Incorrect email
         return response()->json(['error' => 'Email or Password is incorrect!'], 401);
      }
      else if ($isDeactivated == 0) {
         return response()->json(['error' => 'User is deactivated!'], 401);
      } 
      else {
      
         $encryptedPassword = $user->password;
         if (!Hash::check($credentials['password'], $encryptedPassword)) { //Incorrect password
            return response()->json(['error' => 'Email or Password is incorrect!'], 401);
         }
         
         if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
         }
      }
      return $this->respondWithTokenAdmin($token, $userData);
   }

   public function loginClient($credentials, $userData)
   {
      if (!$credentials) {
         return response()->json(['error' => 'Invalid credentials'], 401);
      }

      $user = User::where('email', $credentials['email'])->first();
      if (!$user) { //Incorrect email
         return response()->json(['error' => 'Email or Password is incorrect!'], 401);
      }
      else if ($user->active == 0) {
         return response()->json(['error' => 'User is deactivated!'], 401);
      } 
      else {

         if (!Hash::check($credentials['password'], $user->password)) { //Incorrect password
            return response()->json(['error' => 'Email or Password is incorrect!'], 401);
         }
         if (!$token = Auth::guard('api-client')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
         }
      }
      return $this->respondWithTokenClient($token, $userData);
   }
  

   /**
    * Get the authenticated User.
    *
    * @return \Illuminate\Http\JsonResponse
    */
   public function GetProfileAdmin()
   {
      try {
         # Here we just get information about current user
         return response()->json(Auth::guard('api')->user());

      }  catch (TokenExpiredException $e) {
         return response()->json(['error' => 'Token has expired'], 401);
     }
   }
   public function GetProfileClient()
   {
      try {
         # Here we just get information about current user
         return response()->json(Auth::guard('api-client')->user());

      }  catch (TokenExpiredException $e) {
         return response()->json(['error' => 'Token has expired'], 401);
     }
   }

   /**
    * Log the user out (Invalidate the token).
    *
    * @return \Illuminate\Http\JsonResponse
    */
   public function logoutAdmin()
   {
      Auth::guard('api')->logout();
      return response()->json(['message' => 'Successfully logged out']);   
   }
   public function logoutClient()
   {
      Auth::guard('api-client')->logout();
      return response()->json(['message' => 'Successfully logged out']);   
   }

   /**
    * Refresh a token.
    *
    * @return \Illuminate\Http\JsonResponse
    */
   public function refreshAdmin()
   {
      # When access token will be expired, we are going to generate a new one with this function 
      # and return it here in response
      return $this->respondWithRefreshToken(Auth::guard('api')->setTTL(config('jwt.refresh_ttl'))->refresh());
   }
   public function refreshClient()
   {
      # When access token will be expired, we are going to generate a new one with this function 
      # and return it here in response
      return $this->respondWithRefreshToken(Auth::guard('api-client')->setTTL(config('jwt.refresh_ttl'))->refresh());
   }

   /**
    * Get the token array structure.
    *
    * @param  string $token
    *
    * @return \Illuminate\Http\JsonResponse
    */
   protected function respondWithTokenAdmin($token, $user = null)
   {
      # This function is used to make JSON response with new
      # access token of current user
      return response()->json([
         'access_token' => $token,
         'token_type' => 'bearer',
         'data' => [
            'user' => $user
         ],
         'expires_in_second' => Auth::guard('api')->factory()->getTTL() * 60 
      ]);
   }
   protected function respondWithTokenClient($token, $user = null)
   {
      # This function is used to make JSON response with new
      # access token of current user
      return response()->json([
         'access_token' => $token,
         'token_type' => 'bearer',
         'data' => [
            'user' => $user
         ],
         'expires_in_second' => Auth::guard('api-client')->factory()->getTTL() * 60 
      ]);
   }

   protected function respondWithRefreshToken($token, $user = null)
   {
      # This function is used to make JSON response with new
      # refresh token of current user
      return response()->json([
         'refresh_token' => $token,
         'token_type' => 'bearer',
         // 'data' => [
         //    'user' => $user
         // ],
         'expires_in_second' => config('jwt.refresh_ttl') * 60
      ]);
   }
}