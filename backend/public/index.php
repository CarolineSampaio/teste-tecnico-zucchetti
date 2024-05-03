<?php

$request = $_SERVER['REQUEST_URI'];

switch (true) {
    case stripos($request, '/customers') !== false:
        require_once '../app/routes/customers.php';
        break;

    case stripos($request, '/products') !== false:
        require_once '../app/routes/products.php';
        break;

    default:
        http_response_code(404);
        echo "404";
}