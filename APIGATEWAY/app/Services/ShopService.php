<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Traits\ConsumeExternalService;

class ShopService
{
    use ConsumeExternalService;


    public $baseUri;
    public $client;
    public $secret;
    public $fileService;
    public $shopServiceHelper;


    public function __construct(FileService $fileService, ShopServiceHelper $shopServiceHelper)
    {
        $this->baseUri = config('services.shop.base_uri');
        $this->timeout = 5.0;
        $this->fileService = $fileService;
        $this->shopServiceHelper = $shopServiceHelper;
        $this->client = new Client([
            'base_uri'  =>  $this->baseUri,
            'timeout'   =>  $this->timeout,
        ]);


    }


    public function getproducts(Request $request)
    {
        return $this->getRequest('/products',$request);
    }

    public function all(Request $request)
    {
        //return $this->shopServiceHelper->getProducts($request) ;
        return $this->getRequest('/products',$request);
    }


    public function create(Request $request)
    {

        $response = $this->postRequest('/products', $request);
        return $response;
    }


    public function show(Request $request,$id)
    {
        return $this->getRequest("/products/{$id}",$request);
    }


    public function edit(Request $request,$id)
    {

        return $this->putRequest("/products/{$id}", $request);
    }


    public function delete(Request $request,$id)
    {

        return $this->deleteRequest("/products/{$id}",$request);
    }


}


class ShopServiceHelper extends ShopService {

    public $fileService;
    public $shopService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function getProductsWithGallery(Request $request)
    {
        return $this->fileService->all($request);
    }

    public function getProducts(Request $request)
    {

        return $this->getproducts($request);
    }

}
