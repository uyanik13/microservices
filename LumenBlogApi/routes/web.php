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

$router->get('/posts', 'Post\PostController@index');
$router->post('/posts', 'Post\PostController@store');
$router->get('/posts/{post}', 'Post\PostController@show');
$router->put('/posts/{post}', 'Post\PostController@update');
$router->patch('/posts/{post}', 'Post\PostController@update');
$router->delete('/posts/{post}', 'Post\PostController@destroy');
