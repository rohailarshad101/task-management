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
                $routes->get('task-related-files/(:num)', 'TaskController::getTaskRelatedFiles/$1');
                $routes->post('update/(:num)', 'TaskController::updateTask/$1');
                $routes->post('update/comment/(:num)', 'TaskController::updateTaskComment/$1');
                $routes->delete('(:num)', 'TaskController::delete/$1');
                $routes->post('upload-file', 'TaskController::uploadTaskFile');
                $routes->post('delete-file', 'TaskController::deleteTaskFile');
            });
            $routes->group('categories', static function ($routes) {
                $routes->get('', 'CategoryController::index');
                $routes->get('create', 'CategoryController::create');
                $routes->post('store', 'CategoryController::store');
                $routes->get('edit/(:num)', 'CategoryController::edit/$1');
                $routes->post('update/(:num)', 'CategoryController::update/$1');
                $routes->get('delete/(:num)', 'CategoryController::delete/$1');
            });
            $routes->group('departments', function ($routes) {
                $routes->get('/', 'DepartmentController::index');
                $routes->get('create', 'DepartmentController::create');
                $routes->post('store', 'DepartmentController::store');
                $routes->get('edit/(:num)', 'DepartmentController::edit/$1');
                $routes->post('update/(:num)', 'DepartmentController::update/$1');
                $routes->get('delete/(:num)', 'DepartmentController::delete/$1');
            });

//            $routes->group('roles', static function ($routes) {
//                $routes->get('', 'RoleController::index');
//                $routes->get('create', 'RoleController::create');
//                $routes->post('store', 'RoleController::store');
//                $routes->get('edit/(:num)', 'RoleController::edit/$1');
//                $routes->post('update/(:num)', 'RoleController::update/$1');
//                $routes->get('delete/(:num)', 'RoleController::delete/$1');
//            });
            $routes->group('users', static function ($routes) {
                $routes->get('', 'UsersController::index');
                $routes->get('create', 'UsersController::create');
                $routes->post('store', 'UsersController::store');
                $routes->get('edit/(:num)', 'UsersController::edit/$1');
                $routes->post('update/(:num)', 'UsersController::update/$1');
                $routes->post('active-inactive', 'UsersController::activeInActive');
                $routes->get('delete/(:num)', 'UsersController::delete/$1');
                $routes->get('view/(:num)', 'UsersController::userView/$1');
            });
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
        });
    });
    $routes->post('notifications/mark-as-read', 'NotificationController::markAllAsRead');
    $routes->get('download/(:any)', 'DownloadController::downloadFile/$1');
//    $routes->get('/user/dashboard', 'UsersController::dashboard');
});

// Admin and User dashboard routes

