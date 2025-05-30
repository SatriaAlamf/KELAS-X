<?php

/** @var \Laravel\Lumen\Routing\Router $router */



$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('api/register', ['uses' => 'LoginController@register']);

$router->post('api/login', ['uses' => 'LoginController@login']);

$router->get('api/kategori', ['uses' => 'KategoriController@index']);


$router->group(['prefix' => 'api' , 'middleware' => 'auth'], function() use ($router) {

$router->get('kategori/{id}', ['uses' => 'KategoriController@show']);
$router->delete('kategori/{id}', ['uses' => 'KategoriController@destroy']);
$router->put('kategori/{id}', ['uses' => 'KategoriController@update']);
$router->post('kategori',  ['uses' => 'KategoriController@create']) ;

$router->get('pelanggan',  ['uses' => 'PelangganController@index']) ;
$router->get('pelanggan/{id}',  ['uses' => 'PelangganController@show']) ;
$router->post('pelanggan', ['uses' => 'PelangganController@create']);
$router->delete('pelanggan/{id}', ['uses' => 'PelangganController@destroy']);
$router->put('pelanggan/{id}', ['uses' => 'PelangganController@update']);

$router->post('menu',  ['uses' => 'MenuController@create']) ;
$router->get('menu', ['uses' => 'MenuController@index']);
$router->delete('menu/{id}', ['uses' => 'MenuController@destroy']);
$router->get('menu/{id}',  ['uses' => 'MenuController@show']) ;
$router->post('menu/{id}', ['uses' => 'MenuController@update']);

$router->get('order', ['uses' => 'OrderController@index']);
$router->put('order/{id}', ['uses' => 'OrderController@update']);
$router->get('order/{a}/{b}',  ['uses' => 'OrderController@show']);

$router->get('detail/{a}/{b}',  ['uses' => 'DetailController@show']);

$router->get('user', ['uses' => 'LoginController@index']);
$router->put('user/{id}', ['uses' => 'LoginController@update']);

});