<?php

require_once '../app/models/Order.php';
require_once '../app/services/OrderService.php';
require_once '../app/repositories/OrderRepository.php';
require_once '../app/utils.php';

class OrderController
{
    private $orderService;

    public function __construct()
    {
        $repository = new OrderRepository();
        $this->orderService = new OrderService($repository);
    }

    public function store()
    {
        $body = getBody();

        $response = $this->orderService->createOrder($body);

        if ($response['success'] === true) {
            response(["message" => 'Registered successfully'], 201);
        } else {
            responseError($response['message'], 400);
        }
    }

    public function index()
    {
        $orders = $this->orderService->listAllOrders();
        response($orders, 200);
    }

    public function show()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}
