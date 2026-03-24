<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', function () {
    return redirect()->to('/login');
});

$routes->get('/register','Auth::register');
$routes->post('/register','Auth::store');

$routes->get('/login','Auth::login');
$routes->post('/login','Auth::authenticate');

$routes->get('/logout','Auth::logout');

$routes->get('/unauthorized', 'Auth::unauthorized');

$routes->get('/dashboard','Dashboard::index', [
    'filter' => ['auth', 'role:admin,teacher,coordinator']
]);

$routes->group('', ['filter' => ['auth', 'role:student']], function($routes){

    $routes->get('/profile','ProfileController::show');
    $routes->get('/profile/edit','ProfileController::edit');
    $routes->post('/profile/update','ProfileController::update');

});

$routes->group('', ['filter' => ['auth']], function($routes){

    $routes->get('/students','Students::index', [
        'filter' => 'role:admin,teacher,coordinator'
    ]);

    $routes->get('/students/create','Students::create', [
        'filter' => 'role:admin,teacher'
    ]);

    $routes->post('/students/store','Students::store', [
        'filter' => 'role:admin,teacher'
    ]);

    $routes->post('/students/update/(:num)','Students::update/$1', [
        'filter' => 'role:admin,teacher,coordinator'
    ]);

    $routes->get('/students/delete/(:num)','Students::delete/$1', [
        'filter' => 'role:admin,teacher'
    ]);

});

$routes->group('admin', ['filter' => ['auth', 'role:admin']], function($routes){

    $routes->get('users','AdminController::index');

    $routes->post('users/assign-role/(:num)','AdminController::assignRole/$1');

    $routes->match(['get','post'], 'users/delete/(:num)','AdminController::delete/$1');

});