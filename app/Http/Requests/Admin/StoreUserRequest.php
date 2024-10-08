<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
   /**
    * Determine if the user is authorized to make this request.
    */
   public function authorize(): bool
   {
      return true;
   }

   /**
    * Get the validation rules that apply to the request.
    *
    * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    */
   public function rules(): array
   {
      return [
         'first_name'      => "required|string|max:255",
         'last_name'       => "required|string|max:255",
         'username'        => "nullable|string|max:255",
         "gender"          => "nullable|in:Male,Female",
         'dob'             => 'nullable|date',
         "phone"           => "required|numeric|unique:users,phone",
         "email"           => "required|email|unique:users,email",
         'password'        => "required|string|min:8",
         'profile_picture' => 'nullable',
      ];
   }
}
