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
    return env('APP_NAME') . '-OK';
});
$router->get('foo', function () {
   return 'Hello World';
});
$router->get('show_data', 'Controller@show_data');
$router->get('get_data_by_year/{id}', 'Controller@get_data_by_year');
$router->get('get_data_by_type', 'Controller@get_data_by_type');
$router->get('get_data_by_status/{id}', 'Controller@get_data_by_status');
$router->get('get_data_all_courier/{id}', 'Controller@get_data_all_courier');
$router->get('showCourier/{id}', 'Controller@get_data_courier');
$router->get('get_data_all_payment', 'Controller@get_data_all_payment');
$router->get('get_data_by_drop_code', 'Controller@get_data_by_drop_code');
$router->get('show_data_by_month/{id}', 'Controller@show_data_by_month');
$router->get('show_data_year', 'Controller@get_year');
$router->get('showDataByCourire/{id}', 'Controller@get_data_courier_by_name');
