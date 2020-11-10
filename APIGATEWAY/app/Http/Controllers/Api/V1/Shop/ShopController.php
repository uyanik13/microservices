<?php

namespace App\Http\Controllers\Api\V1\Shop;


use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\ShopService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ShopController  extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the books micro-service
     * @var ShopService
     */
    public $shopService;

    /**
     *  The service to consume the authors micro-service
     * @var $authorService;
     */
    public $authorService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }


    public function index(Request $request)
    {
        return $this->successResponse($this->shopService->all($request));
    }



    public function store(Request $request)
    {


        return $this->successResponse($this->shopService->create($request));
    }



    public function show(Request $request,$id)
    {
        return $this->successResponse($this->shopService->show($request,$id));
    }



    public function update(Request $request, $id)
    {
        return $this->successResponse($this->shopService->edit($request,$id));
    }



    public function destroy(Request $request,$id)
    {
        return $this->successResponse($this->shopService->delete($request,$id));
    }

}
