<?php

$request = $_SERVER['REQUEST_URI'];

switch (true) {
    case stripos($request, '/customers') !== false:
        require_once '../app/routes/customers.php';
        break;

    case stripos($request, '/products') !== false:
        require_once '../app/routes/products.php';
        break;

    case stripos($request, '/payments') !== false:
        require_once '../app/routes/payments.php';
        break;

    case stripos($request, '/orders') !== false:
        require_once '../app/routes/orders.php';
        break;

    default:
        http_response_code(404);
        echo "404";
}
