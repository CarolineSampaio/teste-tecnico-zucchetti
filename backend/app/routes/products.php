<?php
require_once '../app/config.php';
require_once '../app/controllers/ProductController.php';

$method = $_SERVER['REQUEST_METHOD'];

$controller = new ProductController();

if ($method === 'POST') {
    $controller->store();
} else if ($method === 'GET' && !isset($_GET['id'])) {
    $controller->index();
} else if ($method === 'GET' && isset($_GET['id'])) {
    $controller->show();
} else if ($method === 'PUT') {
    $controller->update();
} else if ($method === 'DELETE') {
    $controller->delete();
}
