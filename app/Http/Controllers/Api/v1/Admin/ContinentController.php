<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\BaseAPI;
use App\Http\Requests\Admin\StoreContinentRequest;
use App\Http\Requests\Admin\UpdateContinentRequest;
use App\Http\Resources\ContinentResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ContinentSV;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ContinentController extends BaseAPI
{
    protected $continentSV;
    public function __construct()
    {
        $this->continentSV = new ContinentSV();
    }

    public function index()
    {
        try {
            $continents = $this->continentSV->getAllContinents();
            return $this->successResponse(ContinentResource::collection($continents), 'Get all continents successfully.');
        } catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function store(StoreContinentRequest $request)
    {
        try {
            DB::beginTransaction();
            $params['continent_name']  = getParam($request->all(), 'continent_name');
            $params['profile_picture'] = getParam($request->all(), 'profile_picture');
            $params['description']     = getParam($request->all(), 'description');

            $continent = $this->continentSV->createNewContinent($params);
            DB::commit();
            return $this->successResponse($continent, 'Continent created successfully.');
        } catch(\Exception $e){
           return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function show($global_id)
    {
        try{
            $continent = $this->continentSV->getContinentByGlobalId($global_id);
            return $this->successResponse(new ContinentResource($continent), 'Get continent successfully.');

        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function update(UpdateContinentRequest $request, $global_id)
    {
        try{
            DB::beginTransaction();
            $params['continent_name']  = getParam($request->all(), 'continent_name');
            $params['profile_picture'] = getParam($request->all(), 'profile_picture');
            $params['description']     = getParam($request->all(), 'description');

            $continent = $this->continentSV->updateContinent($params, $global_id);
            DB::commit();
            return $this->successResponse($continent, 'Continent updated successfully.');          
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function deactivateContinent($global_id)
    {
        try{
            $active = 0;
            $continent = $this->continentSV->deactivateContinent($global_id, $active);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
        return $this->successResponse($continent, 'Continent deactivated successfully.');
    }
    public function activateContinent($global_id)
    {
        try{
            $active = 1;
            $continent = $this->continentSV->deactivateContinent($global_id, $active);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
        return $this->successResponse($continent, 'Continent activated successfully.');
    }

}