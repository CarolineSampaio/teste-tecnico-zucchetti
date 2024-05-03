<?php

require_once '../app/models/PaymentMethod.php';
require_once '../app/services/PaymentMethodService.php';
require_once '../app/repositories/PaymentMethodRepository.php';
require_once '../app/utils.php';

class PaymentMethodController
{
    private $paymentMethodService;

    public function __construct()
    {
        $repository = new PaymentMethodRepository();
        $this->paymentMethodService = new PaymentMethodService($repository);
    }

    public function store()
    {
        $body = getBody();

        $response = $this->paymentMethodService->createPaymentMethod($body);

        if ($response['success'] === true) {
            response(["message" => 'Registered successfully'], 201);
        } else {
            responseError('Unable to register', 400);
        }
    }

    public function index()
    {
        $paymentsMethods = $this->paymentMethodService->listAllPaymentMethods();
        response($paymentsMethods, 200);
    }

    public function show()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_SANITIZE_NUMBER_INT, false);
        if (!$id) responseError('id is required', 400);

        $paymentMethod = $this->paymentMethodService->showPaymentMethod($id);
        response($paymentMethod, 200);
    }

    public function update()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_SANITIZE_NUMBER_INT, false);
        if (!$id) responseError('id is required', 400);

        $result = $this->paymentMethodService->updatePaymentMethod($id, getBody());

        if ($result['success'] === true) {
            response(["message" => "Payment method updated"], 201);
        } else {
            responseError("Unable to update", 400);
        }
    }

    public function delete()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_SANITIZE_NUMBER_INT, false);
        if (!$id) responseError('id is required', 400);

        $this->paymentMethodService->deletePaymentMethod($id);
        response(['message' => ''], 204);
    }
}
