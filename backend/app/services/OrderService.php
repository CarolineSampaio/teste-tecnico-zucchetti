<?php
require_once '../app/repositories/OrderRepository.php';

class OrderService
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function createOrder($body)
    {
        $validationRules = [
            'customer_id' => FILTER_SANITIZE_NUMBER_INT,
            'payment_id' => FILTER_SANITIZE_NUMBER_INT,
            'installments' => FILTER_SANITIZE_NUMBER_INT
        ];

        $errors = [];
        foreach ($validationRules as $field => $filter) {
            $value = sanitizeInput($body, $field, $filter);
            if (!$value) {
                $errors[] = "$field is required";
            }
        }

        if (isset($body->products)) {
            foreach ($body->products as $product) {
                $productValidationRules = [
                    'product_id' => FILTER_SANITIZE_NUMBER_INT,
                    'quantity' => FILTER_SANITIZE_NUMBER_INT
                ];

                foreach ($productValidationRules as $field => $filter) {
                    if (!isset($product->$field) || !filter_var($product->$field, $filter)) {
                        $errors[] = "$field is required for each product and must be a valid integer";
                    }
                }
            }
        }

        if (!empty($errors)) {
            responseError(implode(', ', $errors), 400);
        }

        $order = new Order(
            $body->customer_id,
            $body->payment_id,
            $body->installments,
            $body->products
        );

        return $this->orderRepository->registerOrder($order);
    }

    public function listAllOrders()
    {
        return $this->orderRepository->getAll();
    }

    public function showOrder()
    {
    }

    public function updateOrder()
    {
    }

    public function deleteOrder()
    {
    }
}
