<?php

namespace App\Http\Controllers\File;


use App\Models\Gallery;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\StorageFiles;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;


class FileController  extends Controller
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


    public function index():JsonResponse
    {

       //$files = Gallery::orderBy('created_at','DESC')->paginate();
       $files = Gallery::all();
       return $this->successResponse($files);
    }



    public function store(Request $request):JsonResponse
    {
        $storageFiles = new StorageFiles();
        $file = $storageFiles->filesToStorage($request->all());
        return $this->successResponse($file, Response::HTTP_CREATED);
    }


    public function show($file):JsonResponse
    {
        $file = Gallery::findOrFail($file);
        return $this->successResponse($file);
    }



    public function update(Request $request, $file):JsonResponse
    {
        $rules = [
            'title'         =>  'max:255',
            'description'   =>  'min:1',
        ];

        $this->validate($request, $rules);
        $file = Gallery::findOrFail($file);
        $file->fill($request->all());
        if($file->isClean()){
            return $this->errorResponse("At least one value must change", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $file->save();
        return $this->successResponse($file);
    }



    public function destroy($file):JsonResponse
    {
        $file = Gallery::findOrFail($file);
        $file->delete();
        return $this->successResponse($file);
    }
}
