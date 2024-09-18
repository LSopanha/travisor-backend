<?php

namespace App\Services;

use App\Models\Continent;
use App\Models\Country;
use App\Models\Destination;
use App\Models\Message;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;


class MessageSV extends BaseService
{
   public function getQuery()
   {
       return Message::query();
   }

   // Get all messages
   public function getAllMessages() 
   {
      $query = $this->getQuery();
      if (isset($query)) {
         $messages = $query->get();
         return $messages;
      } else {
         throw new \Exception('Query not found');
      }
   }

   // Create new message
   public function createNewMessage($params) 
   {
      $message  = null;

      if (isset($params)) {
         $message = Message::create([
            'name'    => $params['name'],
            'phone'   => $params['phone'],
            'email'   => $params['email'],
            'message' => $params['message']
         ]);
         return $message;
      }
   }

   // Show specific message
   public function getMessageByGlobalId($global_id)
   {
      $message = Message::where('messages.global_id', $global_id)->first();
      if ($message) {
         return $message;
      } else {
         throw new ModelNotFoundException('Message not found');
      }
   }
}