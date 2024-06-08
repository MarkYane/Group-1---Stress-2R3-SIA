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

$router->post('/signup', 'AuthController@signup');
$router->post('/add-to-favorites', 'AuthController@addToFavorites');
$router->get('/gateway', 'GatewayController@handleRequest');
$router->get('/get-favorites', 'FavoritesController@getFavorites');
$router->delete('/remove-favorite', 'GatewayController@removeFavorite');
// routes/web.php

$router->get('/get-user-activity', 'GatewayController@getUserActivity');



