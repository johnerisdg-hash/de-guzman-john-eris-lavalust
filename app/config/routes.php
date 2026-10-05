<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/
/** @var object $router **/

  $router->get('/', 'Welcome::index');

(function() {
require APP_DIR . 'config/middleware.php';
get_config($config);

})();

$router->get('/', 'StudentController::index', ['middleware' => 'studentmiddleware']);

$router->get('/student', 'StudentController::index', ['middleware' => 'studentmiddleware']);
$router->get('/student/profile', 'StudentController::profile', ['middleware' => 'studentmiddleware']);

$router->get('/users','UserController::showUsers');
       


$router->get('/products/login', 'AuthController::login');
$router->post('/products/login', 'AuthController::authenticate');
$router->get('/products/logout', 'AuthController::logout');

$router->group(['prefix' => 'products', 'middleware' => 'productmiddleware'], function ($router) {
    $router->get('/', 'ProductController::index');
    $router->get('/create', 'ProductController::create');
    $router->post('/create', 'ProductController::store');
    $router->get('/edit/{id}', 'ProductController::edit');
    $router->post('/edit/{id}', 'ProductController::update');
    $router->post('/delete/{id}', 'ProductController::delete');
});

// Migration routes: CLI only, so they can't be hit from a browser
if (PHP_SAPI === 'cli') {
    $router->get('create-migration/{migration_class}', 'MigrationController::create_migration');
    $router->get('migrate', 'MigrationController::migrate');
    $router->get('rollback', 'MigrationController::rollback');
    $router->get('rollback-all', 'MigrationController::rollback_all');
    $router->get('refresh', 'MigrationController::refresh');
    $router->get('status', 'MigrationController::status');
}

$router->get('/api/products', 'ApiProductController::index');
$router->post('/api/products', 'ApiProductController::store');
$router->put('/api/products/{id}', 'ApiProductController::update');
$router->delete('/api/products/{id}', 'ApiProductController::delete');
	


$router->post('/api/login', 'ApiAuthController::login');
$router->post('/api/users/create', 'ApiAuthController::create');
$router->post('/api/refresh', 'ApiAuthController::refresh');
$router->post('/api/logout', 'ApiAuthController::logout');

$router->get('/api/users/me', 'ApiUserController::me');
$router->get('/api/users', 'ApiUserController::index');
$router->put('/api/users/{id}', 'ApiUserController::update');
$router->delete('/api/users/{id}', 'ApiUserController::delete');



$router->post('/api/login', 'ApiAuthController::login');


$router->post('/api/users/create', 'ApiAuthController::create');