<?php

$routes = [
    'Item' => [ // Controller
        ['indexAction', '/', 'GET'], // action, url, method
        ['productsAction', '/produits', 'GET'], // action, url, method
        ['servicesAction', '/services&conseils', 'GET'], // action, url, method
        ['contactAction', '/rendezvous', 'GET'], // action, url, method
        ['legalsAction', '/mentions-legales', 'GET'], // action, url, method
        ['partnersAction', '/catalogues', 'GET'], // action, url, method
    ],
];