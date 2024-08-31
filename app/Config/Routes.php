<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'LoginController::index');
$routes->get('/login', 'LoginController::index', ['as' => 'login']);
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

$routes->group('', ['filter' => ['authfilter', 'cors']], static function ($routes) {
    $routes->group('', ['namespace' => "App\Controllers\Admin"], static function ($routes) {
        $routes->group('admin', ['filter' => 'adminAuth'],static function ($routes) {
            $routes->get('dashboard', 'AdminController::dashboard');
            $routes->get('profile', 'AdminController::profile');
            $routes->post('update-profile', 'AdminController::updateUserProfile');
            $routes->get('update/profile/(:num)', 'AdminController::profile');
            $routes->group('tasks', static function ($routes) {
                // get task detail
                $routes->get('', 'TaskController::index');
                $routes->get('create', 'TaskController::create');
                $routes->post('detail', 'TaskController::getTaskDetails');
                $routes->post('store', 'TaskController::store');
                $routes->get('edit/(:num)', 'TaskController::edit/$1');
                $routes->post('update/(:num)', 'TaskController::updateTask/$1');
                $routes->post('update/comment/(:num)', 'TaskController::updateTaskComment/$1');
                $routes->delete('(:num)', 'TaskController::delete/$1');
                $routes->post('upload-file', 'TaskController::uploadTaskFile');
                $routes->post('delete-file', 'TaskController::deleteTaskFile');
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
            $routes->post('update-profile', 'UserController::updateUserProfile');
            $routes->get('update/profile/(:num)', 'UserController::profile');
            $routes->group('tasks', static function ($routes) {
                $routes->get('', 'UserTaskController::index');
                $routes->post('store', 'UserTaskController::store');
                $routes->post('update/comment/(:num)', 'UserTaskController::updateTaskComment/$1');
                $routes->get('edit/(:num)', 'UserTaskController::edit/$1');
                $routes->post('detail', 'UserTaskController::getTaskDetails');
            });
            $routes->post('notifications/mark-as-read', 'NotificationController::markAsRead');
        });
    });
    $routes->get('download/(:any)', 'DownloadController::downloadFile/$1');
//    $routes->get('/user/dashboard', 'UsersController::dashboard');
});

// Admin and User dashboard routes

