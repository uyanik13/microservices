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


$router->get('/gallery',         'File\FileController@index');
$router->post('/gallery',          'File\FileController@store');
$router->get('/gallery/{file}',   'File\FileController@show');
$router->put('/gallery/{file}',    'File\FileController@update');
$router->patch('/gallery/{file}',    'File\FileController@update');
$router->delete('/gallery/{file}',     'File\FileController@destroy');
