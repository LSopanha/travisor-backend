<?php

namespace App\Services;

use App\Models\Continent;
use App\Models\Country;
use App\Models\Destination;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;


class BlogSV extends BaseService
{
   public function getQuery()
   {
       return Blog::query();
   }

   // Get all blogs
   public function getAllBlogs() 
   {
      $query = $this->getQuery();
      if (isset($query)) {
         $blogs = $query->get();
         return $blogs;
      } else {
         throw new \Exception('Query not found');
      }
   }

   // Create new blog
   public function createNewBlog($params) 
   {
      $blog  = null;
      $user_id   = Auth::id();
      $destination_id   = $this->getIdByGlobalId(Destination::class, $params['destination_id']);

      if (isset($params)) {
         $blog = Blog::create([
            'user_id'        => $user_id,
            'destination_id' => $destination_id,
            'title'          => $params['title'],
            'text'           => $params['text'],
         ]);
         return $blog;
      }
   }

   // Show specific blog
   public function getBlogByGlobalId($global_id)
   {
      $blog = Blog::where('blogs.global_id', $global_id)->first();
      if ($blog) {
         return $blog;
      } else {
         throw new ModelNotFoundException('Blog not found');
      }
   }

   // Update specific blog
   public function updateBlog($params, $global_id)
   {
      $blog  = Blog::where('blogs.global_id', $global_id)->first();
      $user_id   = Auth::id();
      $destination_id   = $this->getIdByGlobalId(Destination::class, $params['destination_id']);

      if (isset($blog)) {
         if (isset($params)) {
            $blog->update([
               'user_id'        => $user_id,
               'destination_id' => $destination_id,
               'title'          => $params['title'],
               'text'           => $params['text'],
               ]);
         } 
         return $blog;
      } else {
         throw new ModelNotFoundException('Blog not found');
      }
   }

   // Deactivate/Activate blog
   public function deactivateBlog($global_id, $active)
   {
      $blog  = Blog::where('blogs.global_id', $global_id)->first();
      if (isset($blog)) {
         $blog->update([
            'active' => $active,
         ]);
         return $blog;
      } else {
         throw new ModelNotFoundException('Blog not found');
      }
   }

   public function deleteBlog($global_id)
   {
       $blog = Blog::findOrFail($global_id);
       $blog->delete();
   }

}