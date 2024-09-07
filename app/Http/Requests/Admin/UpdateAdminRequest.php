<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
         'first_name' => "nullable|string|max:255",
         'last_name' => "nullable|string|max:255",
         'username' => "nullable|string|max:255",
         "gender" => "nullable|in:Male,Female",
         'dob' => 'nullable|date', 
         'phone' => 'nullable|numeric', 
         "email" => "nullable|email", 
         'password' => "nullable|string|min:8",
         'profile_picture' => 'nullable',
      ];
   }
}
