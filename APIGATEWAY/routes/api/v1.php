<?php

use App\Http\Controllers\Api\V1\Product\ShopController;


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api\V1',
    'middleware' => [
        'cors',
        'serializer',
         //'serializer:array', // if you want to remove data wrap
        'api.throttle',
    ],
    // each route have a limit of 20 of 1 minutes
    'limit' => 20, 'expires' => 1,
], function ($api) {


    //PRODUCT SERVICE
    $api->get('/products',         'Shop\ShopController@index');

    //FILE SERVICE
    $api->get('/gallery',         'File\FileController@index');




    $api->post('login', [
        'as' => 'user.login',
        'uses' => 'AuthController@login',
    ]);

    $api->post('register', [
        'as' => 'user.register',
        'uses' => 'AuthController@register',
    ]);

    $api->delete('logout', [
        'as' => 'authorizations.destroy',
        'uses' => 'AuthController@logout',
    ]);

    $api->put('refresh', [
        'as' => 'authorizations.update',
        'uses' => 'AuthController@update',
    ]);




    // need authentication
    $api->group(['middleware' => 'api.auth'], function ($api) {




        // GET ALL USERS
        $api->get('users', [
            'as' => 'users.index',
            'uses' => 'UserController@index',
        ]);

         // GET CURRENT USER
         $api->get('user', [
            'as' => 'user.show',
            'uses' => 'UserController@userShow',
        ]);

        // GET ANY USER WITH ID
        $api->get('users/{id}', [
            'as' => 'users.show',
            'uses' => 'UserController@show',
        ]);


        // CREATE AN USER
        $api->post('users', [
            'as' => 'users.store',
            'uses' => 'UserController@store',
        ]);

        // UPDATE USER
        $api->patch('user', [
            'as' => 'user.update',
            'uses' => 'UserController@patch',
        ]);

        // UPDATE PASSWORD
        $api->put('user/password', [
            'as' => 'user.password.update',
            'uses' => 'UserController@editPassword',
        ]);



        //FILE SERVICES
        $api->post('/gallery',          'File\FileController@store');
        $api->get('/gallery/{id}',   'File\FileController@show');
        $api->put('/gallery/{id}',    'File\FileController@update');
        $api->patch('/gallery/{id}',    'File\FileController@update');
        $api->delete('/gallery/{id}',     'File\FileController@destroy');

        //PRODUCT SERVICES
        $api->post('/products',          'Shop\ShopController@store');
        $api->get('/products/{id}',   'Shop\ShopController@show');
        $api->put('/products/{id}',    'Shop\ShopController@update');
        $api->patch('/products/{id}',    'Shop\ShopController@update');
        $api->delete('/products/{id}',     'Shop\ShopController@destroy');

    });
});
