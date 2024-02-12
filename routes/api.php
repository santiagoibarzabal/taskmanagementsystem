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

$router->group(['middleware' => ['auth']], function () use ($router) {
    $router->get('/tasks', 'App\Contexts\Task\Infrastructure\ApiControllers\ListTasksController');
    $router->post('/tasks', 'App\Contexts\Task\Infrastructure\ApiControllers\StoreTaskController');
    $router->delete('/tasks/{id}', 'App\Contexts\Task\Infrastructure\ApiControllers\DeleteTaskController');
    $router->post('/tasks/{id}/status', 'App\Contexts\Task\Infrastructure\ApiControllers\UpdateTaskStatusController');
    $router->post('/tasks/{id}/user', 'App\Contexts\Task\Infrastructure\ApiControllers\UpdateTaskAssigneeController');
});

$router->post('/users', 'App\Contexts\User\Infrastructure\ApiControllers\GetApiTokenController');

