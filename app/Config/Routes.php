<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 *
 * Route map
 * ---------
 *  GET  /                 -> Home::index            (public landing)
 *  GET  /login            -> Auth::login            (login form)
 *  POST /login            -> Auth::attemptLogin     (validate + sign in)
 *  GET  /register         -> Auth::register         (register form)
 *  POST /register         -> Auth::attemptRegister  (create account)
 *  POST /logout                -> Auth::logout            (destroy session)
 *  GET  /dashboard             -> Dashboard::index        (protected by AuthFilter)
 *  POST /notes                 -> Dashboard::storeNote    (CSRF-protected)
 *  POST /notes/{id}/delete     -> Dashboard::deleteNote   (CSRF-protected)
 */

// Public landing page
$routes->get('/', 'Home::index');

// Authentication
$routes->get('login',     'Auth::login');
$routes->post('login',    'Auth::attemptLogin');
$routes->get('register',  'Auth::register');
$routes->post('register', 'Auth::attemptRegister');
$routes->post('logout',   'Auth::logout');

// Protected area — `auth` filter is registered in app/Config/Filters.php
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard',            'Dashboard::index');
    $routes->post('notes',               'Dashboard::storeNote');
    $routes->post('notes/(:num)/delete', 'Dashboard::deleteNote/$1');
});
