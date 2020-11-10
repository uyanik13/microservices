<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class PostController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
       
       $posts = Post::all();
       return $this->successResponse($posts);
    }


    /**
     * Store a single post information
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'user_id'       =>  'required|integer',
            'category_id'   =>  'required|integer',
            'title'         =>  'required|max:160',
            'description'   =>  'required',
        ];
        $this->validate($request, $rules);

        $post = Post::create($request->all());

        return $this->successResponse($post, Response::HTTP_CREATED);
    }


    /**
     * Storing a single post data
     * @param $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($post)
    {
        $post = Post::findOrFail($post);
        return $this->successResponse($post);
    }


    /**
     * @param Request $request
     * @param $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $post)
    {
        $rules = [
            'title'         =>  'max:255',
            'description'   =>  'min:1',
        ];

        $this->validate($request, $rules);
        $post = Post::findOrFail($post);
        $post->fill($request->all());
        if($post->isClean()){
            return $this->errorResponse("At least one value must change", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $post->save();
        return $this->successResponse($post);
    }


    /**
     * Delete post information
     * @param $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($post)
    {
        $post = Post::findOrFail($post);
        $post->delete();
        return $this->successResponse($post);
    }
}
