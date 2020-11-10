<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class PostService
{
    use ConsumeExternalService;

    /**
     * The base uri to consume posts service
     * @var string
     */
    public $baseUri;

    /**
     * Authorization secret to pass to current api
     * @var string
     */
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.posts.base_uri');
        $this->secret = config('services.posts.secret');
    }


    public function all()
    {
        return $this->performRequest('GET', '/posts');
    }

    public function create($data)
    {
        return $this->performRequest('POST', '/posts', $data);
    }

    public function show($post)
    {
        return $this->performRequest('GET', "/posts/{$post}");
    }

    public function edit($data, $post)
    {
        return $this->performRequest('PUT', "/posts/{$post}", $data);
    }

    public function delete($post)
    {
        return $this->performRequest('DELETE', "/posts/{$post}");
    }
}