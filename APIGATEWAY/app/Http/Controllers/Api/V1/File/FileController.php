<?php

namespace App\Http\Controllers\Api\V1\File;


use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class FileController  extends Controller
{
    use ApiResponser;


    /**
     * The service to consume the books micro-service
     * @var FileService
     */
    public $fileService;
    /**
     *  The service to consume the authors micro-service
     * @var $authorService;
     */
    public $authorService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }



    public function index(Request $request):JsonResponse
    {
        return $this->successResponse($this->fileService->all($request));
    }



    public function store(Request $request):JsonResponse
    {

        return $this->successResponse($this->fileService->create($request));
    }



    public function show(Request $request,$id):JsonResponse
    {
        return $this->successResponse($this->fileService->show($request,$id));
    }



    public function update(Request $request,$id):JsonResponse
    {

        return $this->successResponse($this->fileService->edit($request,$id));
    }



    public function destroy(Request $request,$id):JsonResponse
    {
        return $this->successResponse($this->fileService->delete($request,$id));
    }

}
