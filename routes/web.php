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
    //return $router->app->version();
});

$router->group(['prefix' => 'v1/login','middleware' => ['logger.audit']], function () use ($router) {
    $router->post('/', ['uses' => 'AuthLoginController']);
});

$router->group(['prefix' => 'v1', 'middleware' => ["auth.jwt", "logger.audit"]], function() use ($router) {

    // Token
    $router->group(['prefix' => 'token'], function () use ($router) {
        $router->post('refresh',  ['uses' => 'AuthRefreshController']);
        $router->post('validate', ['uses' => 'AuthValidateController']);
    });

    // Product
    $router->group(['prefix' => 'product'], function () use ($router) {
           $router->post('list', ['uses' => 'ProductController']);
    });
});
