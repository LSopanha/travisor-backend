<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Api\v1\BaseAPI;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserSV;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ClientController extends BaseAPI
{
    protected $userSV;
    public function __construct()
    {
        $this->userSV = new UserSV();
    }

    public function index()
    {
        try {
            $role = 2;
            $users = $this->userSV->getAllUsers($role);
            return $this->successResponse($users, 'Get all users successfully.');
        } catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $params['first_name']      = getParam($request->all(), 'first_name');
            $params['last_name']       = getParam($request->all(), 'last_name');
            $params['username']        = getParam($request->all(), 'username');
            $params['gender']          = getParam($request->all(), 'gender');
            $params['dob']             = getParam($request->all(), 'dob');
            $params['phone']           = getParam($request->all(), 'phone');
            $params['email']           = getParam($request->all(), 'email');
            $params['password']        = getParam($request->all(), 'password');
            $params['profile_picture'] = getParam($request->all(), 'profile_picture');
            $role = 2;
            $admin = $this->userSV->createNewUser($params, $role);
            DB::commit();
            return $this->successResponse($admin, 'Admin created successfully.');
        } catch(\Exception $e){
           return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function show($global_id)
    {
        try{
            $admin = $this->userSV->getUserByGlobalId($global_id);
            return $this->successResponse(new UserResource($admin), 'Get admin successfully.');

        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function selfRegister(StoreUserRequest $request)
    {
        try{
            DB::beginTransaction();
            $params['first_name'] = getParam($request->all(), 'first_name');
            $params['last_name']  = getParam($request->all(), 'last_name');
            $params['username']   = getParam($request->all(), 'username');
            $params['phone']      = getParam($request->all(), 'phone');
            $params['email']      = getParam($request->all(), 'email');
            $params['password']   = getParam($request->all(), 'password');
            $user                 = User::where('phone', $params['phone'])->first();
            if ($user) {
                throw new \Exception('User already exists');
            } 
            $register = $this->userSV->selfRegister($params);
            DB::commit();
            return $this->successResponse($register, 'User register successfully.');
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }


    public function update(UpdateUserRequest $request, $global_id)
    {
        try{
            DB::beginTransaction();
            $params['name']            = getParam($request->all(), 'name');
            $params['gender']          = getParam($request->all(), 'gender');
            $params['phone']           = getParam($request->all(), 'phone');
            $params['email']           = getParam($request->all(), 'email');
            $params['password']        = getParam($request->all(), 'password');
            $params['profile_picture'] = getParam($request->all(), 'profile_picture');

            $admin                     = $this->userSV->updateUser($params, $global_id);
            DB::commit();
            return $this->successResponse($admin, 'Admin updated successfully.');          
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function deactivateUser($global_id)
    {
        try{
            $active = 0;
            $admin = $this->userSV->deactivateUser($global_id, $active);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
        return $this->successResponse($admin, 'Admin deactivated successfully.');
    }
    public function activateUser($global_id)
    {
        try{
            $active = 1;
            $admin = $this->userSV->deactivateUser($global_id, $active);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
        return $this->successResponse($admin, 'Admin activated successfully.');
    }

}