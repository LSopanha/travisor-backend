<?php

namespace App\Http\Controllers\Api\v1\Client;

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


    public function show($global_id)
    {
        try{
            $destination = $this->destinationSV->getDestinationByGlobalId($global_id);
            return $this->successResponse(new DestinationResource($destination), 'Get destination successfully.');

        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function destinationsByCountry($global_id) 
    {
        try{
            $destinations = $this->destinationSV->getDestinationByCountry($global_id);
            return $this->successResponse(DestinationResource::collection($destinations), 'Get destination successfully.');

        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

    }
}