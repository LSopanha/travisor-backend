<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\BaseAPI;
use App\Http\Requests\Admin\StoreDestinationRequest;
use App\Http\Requests\Admin\UpdateDestinationRequest;
use App\Http\Resources\DestinationResource;
use App\Services\DestinationSV;
use Illuminate\Support\Facades\DB;

class DestinationController extends BaseAPI
{
    protected $destinationSV;
    public function __construct()
    {
        $this->destinationSV = new DestinationSV();
    }

    public function index()
    {
        try {
            $destinations = $this->destinationSV->getAllDestinations();
            return $this->successResponse(DestinationResource::collection($destinations), 'Get all destinations successfully.');
        } catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function store(StoreDestinationRequest $request)
    {
        try {
            DB::beginTransaction();
            $params['destination_name'] = getParam($request->all(), 'destination_name');
            $params['profile_picture']  = getParam($request->all(), 'profile_picture');
            $params['description']      = getParam($request->all(), 'description');
            $params['continent_id']     = getParam($request->all(), 'continent_id');
            $params['country_id']       = getParam($request->all(), 'country_id');

            $destination = $this->destinationSV->createNewDestination($params);
            DB::commit();
            return $this->successResponse($destination, 'Destiantion created successfully.');
        } catch(\Exception $e){
           return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function show($global_id)
    {
        try{
            $destination = $this->destinationSV->getDestinationByGlobalId($global_id);
            return $this->successResponse(new DestinationResource($destination), 'Get destination successfully.');

        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function update(UpdateDestinationRequest $request, $global_id)
    {
        try{
            DB::beginTransaction();
            $params['destination_name'] = getParam($request->all(), 'destination_name');
            $params['profile_picture']  = getParam($request->all(), 'profile_picture');
            $params['description']      = getParam($request->all(), 'description');
            $params['continent_id']     = getParam($request->all(), 'continent_id');
            $params['country_id']       = getParam($request->all(), 'country_id');

            $destination = $this->destinationSV->UpdateDestination($params, $global_id);
            DB::commit();
            return $this->successResponse($destination, 'Destination updated successfully.');          
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function deactivateDestination($global_id)
    {
        try{
            $active = 0;
            $destination = $this->destinationSV->deactivateDestination($global_id, $active);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
        return $this->successResponse($destination, 'Destination deactivated successfully.');
    }
    public function activateDestination($global_id)
    {
        try{
            $active = 1;
            $destination = $this->destinationSV->deactivateDestination($global_id, $active);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
        return $this->successResponse($destination, 'Destination activated successfully.');
    }

}