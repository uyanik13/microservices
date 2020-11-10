<?php



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/',         function (){
    return 'Not Authhorized';
});

$router->get('/products',         'Product\ProductController@index');
$router->post('/products',          'Product\ProductController@store');
$router->get('/products/{product}',   'Product\ProductController@show');
$router->put('/products/{product}',    'Product\ProductController@update');
$router->patch('/products/{product}',    'Product\ProductController@update');
$router->delete('/products/{product}',     'Product\ProductController@destroy');
