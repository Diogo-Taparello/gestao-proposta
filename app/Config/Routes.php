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
        $routes->get('proposta/(:num)', 'Api\V1\proposta::index/$1');
        $routes->post('proposta/(:num)/submit', 'Api\V1\proposta::change_status/$1/SUBMITTED');
        $routes->post('proposta/(:num)/approve', 'Api\V1\proposta::change_status/$1/APPROVED');
        $routes->post('proposta/(:num)/reject', 'Api\V1\proposta::change_status/$1/REJECTED');
        $routes->post('proposta/(:num)/cancel', 'Api\V1\proposta::change_status/$1/CANCELED');
        $routes->get('proposta/(:num)/auditoria', 'Api\V1\proposta::auditoria/$1');
        $routes->get('proposta', 'Api\V1\proposta::all');
        $routes->post('proposta', 'Api\V1\proposta::add');

    });
});