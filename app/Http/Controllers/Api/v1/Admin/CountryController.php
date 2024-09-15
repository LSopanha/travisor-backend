<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\BaseAPI;
use App\Http\Requests\Admin\StoreCountryRequest;
use App\Http\Requests\Admin\UpdateCountryRequest;
use App\Http\Resources\CountryResource;
use App\Http\Resources\UserResource;
use App\Services\CountrySV;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CountryController extends BaseAPI
{
    protected $countrySV;
    public function __construct()
    {
        $this->countrySV = new CountrySV();
    }

    public function index()
    {
        try {
            $countries = $this->countrySV->getAllCountries();
            return $this->successResponse(CountryResource::collection($countries), 'Get all countries successfully.');
        } catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function store(StoreCountryRequest $request)
    {
        try {
            DB::beginTransaction();
            $params['country_name']    = getParam($request->all(), 'country_name');
            $params['profile_picture'] = getParam($request->all(), 'profile_picture');
            $params['description']     = getParam($request->all(), 'description');
            $params['continent_id']    = getParam($request->all(), 'continent_id');

            $country = $this->countrySV->createNewCountry($params);
            DB::commit();
            return $this->successResponse($country, 'Country created successfully.');
        } catch(\Exception $e){
           return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function show($global_id)
    {
        try{
            $country = $this->countrySV->getCountryByGlobalId($global_id);
            return $this->successResponse(new CountryResource($country), 'Get country successfully.');

        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function update(UpdateCountryRequest $request, $global_id)
    {
        try{
            DB::beginTransaction();
            $params['country_name']    = getParam($request->all(), 'country_name');
            $params['profile_picture'] = getParam($request->all(), 'profile_picture');
            $params['description']     = getParam($request->all(), 'description');
            $params['continent_id']    = getParam($request->all(), 'continent_id');

            $country = $this->countrySV->UpdateCountry($params, $global_id);
            DB::commit();
            return $this->successResponse($country, 'Country updated successfully.');          
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function deactivateCountry($global_id)
    {
        try{
            $active = 0;
            $country = $this->countrySV->deactivateCountry($global_id, $active);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
        return $this->successResponse($country, 'Country deactivated successfully.');
    }
    public function activateCountry($global_id)
    {
        try{
            $active = 1;
            $country = $this->countrySV->deactivateCountry($global_id, $active);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
        return $this->successResponse($country, 'Country activated successfully.');
    }

}