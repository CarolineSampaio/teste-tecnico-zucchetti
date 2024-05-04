<?php
require_once '../app/config.php';
require_once '../app/controllers/OrderController.php';

$method = $_SERVER['REQUEST_METHOD'];

$controller = new OrderController();

if ($method === 'POST') {
    $controller->store();
} else if ($method === 'GET' && !isset($_GET['id']) && !isset($_GET['customer_id'])) {
    $controller->index();
} else if ($method === 'GET' && isset($_GET['id']) || isset($_GET['customer_id'])) {
    $controller->show();
} else if ($method === 'PUT') {
    $controller->update();
} else if ($method === 'DELETE') {
    $controller->delete();
}
