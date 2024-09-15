<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\BaseAPI;
use App\Http\Requests\Admin\StoreUserRequest;
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
            $admins = $this->userSV->getAllUsers($role);
            return $this->successResponse($admins, 'Get all users successfully.');
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
            $admin = $this->userSV->createNewAdmin($params, $role);
            DB::commit();
            return $this->successResponse($admin, 'User created successfully.');
        } catch(\Exception $e){
           return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function show($global_id)
    {
        try{
            $admin = $this->userSV->getUserByGlobalId($global_id);
            return $this->successResponse(new UserResource($admin), 'Get user successfully.');

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
            return $this->successResponse($admin, 'User updated successfully.');          
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function deactivateClient($global_id)
    {
        try{
            $active = 0;
            $admin = $this->userSV->deactivateUser($global_id, $active);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
        return $this->successResponse($admin, 'User deactivated successfully.');
    }
    public function activateClient($global_id)
    {
        try{
            $active = 1;
            $admin = $this->userSV->deactivateUser($global_id, $active);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
        return $this->successResponse($admin, 'User activated successfully.');
    }

}