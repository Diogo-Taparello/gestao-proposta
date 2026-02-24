<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->group('api', function ($routes) {
    $routes->group('v1', function ($routes) {

        //Rotas Swagger
        $routes->group('docs', function ($routes) {
            $routes->get('generate', 'swagger::generate');
            $routes->get('ui', 'swagger::index');
        });

        //Rotas Entidades
        $routes->get('cliente/(:num)', 'Api\V1\cliente::index/$1');
        $routes->post('cliente', 'Api\V1\cliente::add');
        $routes->get('proposta', 'Api\V1\proposta::index');
        $routes->get('auditoria', 'Api\V1\auditoria::index');

    });
});