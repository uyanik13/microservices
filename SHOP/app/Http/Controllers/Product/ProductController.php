<?php

namespace App\Http\Controllers\Product;


use App\Models\Product;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\StorageFiles;

class ProductController  extends Controller
{
    use ApiResponser;

     public $storageFiles;
     public $createdProduct;


    public function __construct()
    {

        $this->storageFiles = new StorageFiles();
    }


    public function index():JsonResponse
    {

       $products = Product::with('galleries')->orderBy('created_at')->paginate(20);
       return $this->successResponse($products);


    }



    public function store(Request $request):JsonResponse
    {





        $rules = [
            'user_id'       =>  'required|integer',
            'category_id'   =>  'required|integer',
            'title'         =>  'required|max:255',
            'content'       =>  'required',
            'price'         =>  'required',
            'thumbnail'     =>  'required',
        ];

        $this->validate($request, $rules);
        $this->createProduct($request);
        $this->storageFiles->filesToStorage($request,$this->createdProduct->id);

        return $this->successResponse($this->createdProduct, Response::HTTP_CREATED);
    }



    public function show($product):JsonResponse
    {
        $product = Product::findOrFail($product);
        return $this->successResponse($product);
    }



    public function update(Request $request, $product):JsonResponse
    {

        $rules = [
            'title'         =>  'max:255',
            'description'   =>  'min:1',
        ];

        $this->validate($request, $rules);

        $product = Product::findOrFail($product);

        $product->fill(file_to_url($request->all()));
        if($product->isClean()){
            return $this->errorResponse("At least one value must change", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $product->save();
        return $this->successResponse($product);
    }



    public function destroy($product):JsonResponse
    {
        $product = Product::findOrFail($product);
        $this->storageFiles->fiLesDeleteFromDB($product->galleries);
        $this->storageFiles->fiLesDeleteFromStorage($product->galleries);
        $product->delete();
        return $this->successResponse($product);
    }


    public function createProduct(Request $request):JsonResponse
    {

        $data = $request->except(['images']);
        $this->createdProduct = Product::Create(file_to_url($data));

        return $this->successResponse($this->createdProduct, Response::HTTP_CREATED);
    }


}


