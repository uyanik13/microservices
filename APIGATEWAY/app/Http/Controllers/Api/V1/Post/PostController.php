<?php


namespace App\Http\Controllers\Api\V1\Post;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the books micro-service
     * @var PostService
     */
    public $postService;

    /**
     *  The service to consume the authors micro-service
     * @var $authorService;
     */
    public $authorService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }


    /**
     * Get Book data
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->successResponse($this->postService->all());
    }


    /**
     * Save an book data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->postService->create($request->all()));
    }


    /**
     * Show a single book details
     * @param $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($post)
    {
        return $this->successResponse($this->postService->show($post));
    }


    /**
     * Update a single book data
     * @param Request $request
     * @param $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $post)
    {
        
        return $this->successResponse($this->postService->edit($request->all(),$post));
    }


    /**
     * Delete a single book details
     * @param $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($post)
    {
        return $this->successResponse($this->postService->delete($post));
    }

}
