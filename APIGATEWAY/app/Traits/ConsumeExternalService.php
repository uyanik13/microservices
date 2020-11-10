<?php

namespace App\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

trait ConsumeExternalService
{


    /*
    |--------------------------------------------------------------------------
    | GET REQUEST
    |--------------------------------------------------------------------------
    |
    | This request allow you to send GET requests with Guzzle/Client.
    |
    */

    public function getRequest($requestUrl, Request $request)
    {

        $headers['Authorization'] = $request->header('Authorization');
        $response = $this->client->request('GET', $requestUrl, ['headers'   => $headers]);
        return $response->getBody()->getContents();
    }


    /*
    |--------------------------------------------------------------------------
    | POST REQUEST
    |--------------------------------------------------------------------------
    |
    | This request allow you to send POST requests with Guzzle/Client.
    |
    */


    public function postRequest($requestUrl, Request $request)
    {

        $dataWithImages = $request->only(['images']);

        $dataWithoutImages = $request->except(['images']);

        $output = [];

        $output = request_to_multi_from_data($dataWithImages);

        foreach($dataWithoutImages as $key => $value){

            $output[] = [
                'name'     => $key,
                'contents' => $value,
            ];

        }


        //$response = Http::asForm()->post($this->baseUri.$requestUrl, $output);


        $request->has('thumbnail')
         ?  $response = $this->client->request('POST',$requestUrl, ['multipart' => $output])
         :  $response = $this->client->request('POST',$requestUrl, ['form_params' => $dataWithoutImages]);




        return $response->getBody()->getContents();
    }



    /*
    |--------------------------------------------------------------------------
    | PUT/PATCH REQUEST
    |--------------------------------------------------------------------------
    |
    | This request allow you to send PUT/PATCH requests with Guzzle/Client.
    |
    */


    public function putRequest($requestUrl, Request $request)
    {

        $dataWithImages = $request->only(['images']);

        $dataWithoutImages = $request->except(['images']);

        $output = [];

        $output = request_to_multi_from_data($dataWithImages);



        foreach($dataWithoutImages as $key => $value){

            $output[] = [
                'name'     => $key,
                'contents' => $value,
            ];

        }


        $request->has('images')
         ?  $response = $this->client->request('PUT',$requestUrl, ['multipart' => $output])
         :  $response = $this->client->request('PUT',$requestUrl, ['form_params' => $dataWithoutImages]);




        return $response->getBody()->getContents();
    }


     /*
    |--------------------------------------------------------------------------
    | DELETE REQUEST
    |--------------------------------------------------------------------------
    |
    | This request allow you to send DELETE requests with Guzzle/Client.
    |
    */



    public function deleteRequest($requestUrl, Request $request)
    {
        //$headers['Authorization'] = $request->header('Authorization');
        $response = $this->client->request('DELETE', $requestUrl);
        return $response->getBody()->getContents();
    }



}
