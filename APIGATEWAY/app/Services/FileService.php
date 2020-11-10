<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Traits\ConsumeExternalService;

class FileService
{
    use ConsumeExternalService;

    /**
     * The base uri to consume posts service
     * @var string
     */
    public $baseUri;
    public $client;
    /**
     * Authorization secret to pass to current api
     * @var string
     */
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.file.base_uri');
        $this->timeout = 5.0;
        $this->client = new Client([
            'base_uri'  =>  $this->baseUri,
            'timeout'   =>  $this->timeout,
        ]);

    }


    public function all(Request $request)
    {
        return $this->getRequest('/gallery',$request);
    }

    public function create(Request $request)
    {
        return $this->postRequest('/gallery', $request);
    }

    public function show(Request $request,$id)
    {
        return $this->getRequest("/gallery/{$id}",$request);
    }

    public function edit(Request $request,$id)
    {
        return $this->putRequest("/gallery/{$id}", $request);
    }

    public function delete(Request $request,$id)
    {
        return $this->deleteRequest("/gallery/{$id}",$request);
    }
}
