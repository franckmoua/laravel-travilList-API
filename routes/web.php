<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->get('/home', [
    'as' => '/home', 'uses' => 'HomeController@showHomePage'
]);



$router->group(['prefix' => 'api/'], function() use($router){
    $router->get('locations', 'LocationController@index');
    $router->post('locations', 'LocationController@create');
    $router->get('locations/{id}', 'LocationController@show');
    $router->delete('locations/{id}', 'LocationController@destroy');
  });

  $router->group(['prefix' => 'api/'], function() use($router){
    $router->get('locations/{id}/places', 'PlaceController@index');
    $router->post('locations/{id}/places', 'PlaceController@create');
    $router->get('places/{id}', 'PlaceController@show');
    $router->put('places/{id}', 'PlaceController@update');
    $router->delete('places/{id}', 'PlaceController@destroy');
  });