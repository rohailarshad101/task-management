<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'LoginController::index');
$routes->get('/login', 'LoginController::index', ['as' => 'login']);
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

$routes->group('', ['filter' => 'authfilter'], static function ($routes) {
    $routes->group('', ['namespace' => "App\Controllers\Admin"], static function ($routes) {
        $routes->group('admin', static function ($routes) {
            $routes->get('dashboard', 'AdminController::dashboard');
            $routes->get('profile', 'AdminController::profile');
            $routes->get('update/profile/(:num)', 'AdminController::profile');
            $routes->get('tasks', 'TaskController::index');
            $routes->get('tasks/create', 'TaskController::create');
            $routes->post('tasks/store', 'TaskController::store');
            $routes->get('tasks/edit/(:num)', 'TaskController::edit/$1');
            $routes->post('tasks/update/(:num)', 'TaskController::update/$1');
            $routes->delete('tasks/(:num)', 'TaskController::delete/$1');
            $routes->group('', ['filter' => 'cors'], static function (RouteCollection $routes): void {
//                $routes->options('product', '\Dummy');
                $routes->post('tasks/upload-file', 'TaskController::uploadTaskFile');
                $routes->post('tasks/delete-file', 'TaskController::deleteTaskFile');
            });


            $routes->get('categories', 'CategoryController::index');
            $routes->get('categories/create', 'CategoryController::create');
            $routes->post('categories/store', 'CategoryController::store');
            $routes->get('categories/edit/(:num)', 'CategoryController::edit/$1');
            $routes->post('categories/update/(:num)', 'CategoryController::update/$1');
            $routes->get('categories/delete/(:num)', 'CategoryController::delete/$1');

            $routes->get('users', 'UsersController::index');
            $routes->get('users/create', 'UsersController::create');
            $routes->post('users/store', 'UsersController::store');
            $routes->get('users/edit/(:num)', 'UsersController::edit/$1');
            $routes->post('users/update/(:num)', 'UsersController::update/$1');
            $routes->get('users/delete/(:num)', 'UsersController::delete/$1');
        });
    });
    $routes->group('', ['namespace' => "App\Controllers\User"], static function ($routes) {
        $routes->group('user', static function ($routes) {
            $routes->get('dashboard', 'UserController::dashboard');
            $routes->get('profile', 'UserController::profile');
            $routes->get('update/profile/(:num)', 'UserController::profile');
            $routes->get('tasks', 'UserTaskController::index');
            $routes->post('tasks/store', 'UserTaskController::store');
            $routes->get('tasks/edit/(:num)', 'UserTaskController::edit/$1');
            $routes->post('tasks/update/(:num)', 'UserTaskController::update/$1');
        });
    });
//    $routes->get('/user/dashboard', 'UsersController::dashboard');
});

// Admin and User dashboard routes

