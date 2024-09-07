<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\BaseAPI;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AdminSV;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends BaseAPI
{
    protected $adminSV;
    public function __construct()
    {
        $this->adminSV = new AdminSV();
    }

    public function index()
    {
        try {
            $admins = $this->adminSV->getAllAdmins();
            return $this->successResponse($admins, 'Get all admins successfully.');
        } catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function store(StoreAdminRequest $request)
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
           
            $admin = $this->adminSV->createNewAdmin($params);
            DB::commit();
            return $this->successResponse($admin, 'Admin created successfully.');
        } catch(\Exception $e){
           return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function show($global_id)
    {
        try{
            $admin = $this->adminSV->getAdminByGlobalId($global_id);
            return $this->successResponse(new UserResource($admin), 'Get admin successfully.');

        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function update(UpdateAdminRequest $request, $global_id)
    {
        try{
            DB::beginTransaction();
            $params['name'] = getParam($request->all(), 'name');
            $params['gender'] = getParam($request->all(), 'gender');
            $params['phone'] = getParam($request->all(), 'phone');
            $params['email'] = getParam($request->all(), 'email');
            $params['password'] = getParam($request->all(), 'password');
            $params['profile_picture'] = getParam($request->all(), 'profile_picture');
            $admin = $this->adminSV->updateAdmin($params, $global_id);  
            DB::commit();
            return $this->successResponse($admin, 'Admin updated successfully.');          
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function deactivateAdmin($global_id)
    {
        try{
            $active = 0;
            $admin = $this->adminSV->deactivateAdmin($global_id, $active);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
        return $this->successResponse($admin, 'Admin deactivated successfully.');
    }
    public function activateAdmin($global_id)
    {
        try{
            $active = 1;
            $admin = $this->adminSV->deactivateAdmin($global_id, $active);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
        return $this->successResponse($admin, 'Admin activated successfully.');
    }

}