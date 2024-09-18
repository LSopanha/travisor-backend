<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Api\v1\BaseAPI;
use App\Http\Requests\Client\StoreMessageRequest;
use App\Services\MessageSV;
use Illuminate\Support\Facades\DB;

class MessageController extends BaseAPI
{
    protected $messageSV;
    public function __construct()
    {
        $this->messageSV = new MessageSV();
    }

    public function store(StoreMessageRequest $request)
    {
        try {
            DB::beginTransaction();
            $params['name'] = getParam($request->all(), 'name');
            $params['phone']  = getParam($request->all(), 'phone');
            $params['email']      = getParam($request->all(), 'email');
            $params['message']     = getParam($request->all(), 'message');

            $message = $this->messageSV->createNewMessage($params);
            DB::commit();
            return $this->successResponse($message, 'Message created successfully.');
        } catch(\Exception $e){
           return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}