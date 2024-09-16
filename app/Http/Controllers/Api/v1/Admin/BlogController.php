<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\BaseAPI;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Services\BlogSV;
use Illuminate\Support\Facades\DB;

class BlogController extends BaseAPI
{
    protected $blogSV;
    public function __construct()
    {
        $this->blogSV = new BlogSV();
    }

    public function index()
    {
        try {
            $blogs = $this->blogSV->getAllBlogs();
            return $this->successResponse(BlogResource::collection($blogs), 'Get all blogs successfully.');
        } catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function store(StoreBlogRequest $request)
    {
        try {
            DB::beginTransaction();
            $params['user_id']        = $request->user_id;
            $params['destination_id'] = $request->destination_id;
            $params['title']          = $request->title;
            $params['text']           = $request->text;
    
            $blog = $this->blogSV->createNewBlog($params);
            DB::commit();
            return $this->successResponse($blog, 'Blog created successfully.');
        } catch (\Exception $e) {
            DB::rollBack(); // Make sure to rollback on failure
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
    
    public function show($global_id)
    {
        try{
            $blog = $this->blogSV->getBlogByGlobalId($global_id);
            return $this->successResponse(new BlogResource($blog), 'Get blog successfully.');

        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function update(UpdateBlogRequest $request, $global_id)
    {
        try{
            DB::beginTransaction();
            $params['user_id']        = $request->user_id;
            $params['destination_id'] = $request->destination_id;
            $params['title']          = $request->title;
            $params['text']           = $request->text;

            $blog = $this->blogSV->UpdateBlog($params, $global_id);
            DB::commit();
            return $this->successResponse($blog, 'Blog updated successfully.');          
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function deactivateBlog($global_id)
    {
        try{
            $active = 0;
            $blog = $this->blogSV->deactivateBlog($global_id, $active);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
        return $this->successResponse($blog, 'Blog deactivated successfully.');
    }
    public function activateBlog($global_id)
    {
        try{
            $active = 1;
            $blog = $this->blogSV->deactivateBlog($global_id, $active);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
        return $this->successResponse($blog, 'Blog activated successfully.');
    }

}