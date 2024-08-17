<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\BaseAPI;
use App\Models\User;
use App\Services\RoleSV;
use App\Services\UserSV;
use Request;

class RoleController extends BaseAPI
{
   protected $roleSV;
   public function __construct(){
       $this->roleSV = new RoleSV();
   }
   /**
    * Display a listing of the resource.
    */
   public function index(Request $request)
   {
       try{
           $param['order_by'] = 'asc';
           $roles = $this->roleSV->getAll($param);
       }catch (\Exception $e) {
           return $this->errorResponse($e->getMessage(), $e->getCode());
       }
       return $this->successResponse($roles, "Get all role successfully.");
   }
}