<?php

require_once '../app/models/Customer.php';
require_once '../app/services/CustomerService.php';
require_once '../app/repositories/CustomerRepository.php';
require_once '../app/utils.php';

class CustomerController
{
    private $customerService;

    public function __construct()
    {
        $repository = new CustomerRepository();
        $this->customerService = new CustomerService($repository);
    }

    public function store()
    {
        $body = getBody();

        $response = $this->customerService->createCustomer($body);

        if ($response['success'] === true) {
            response(["message" => 'Registered successfully'], 201);
        } else {
            responseError('Unable to register', 400);
        }
    }

    public function index()
    {
        $customers = $this->customerService->listAllCustomers();
        response($customers, 200);
    }

    public function show()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_SANITIZE_NUMBER_INT, false);
        if (!$id) responseError('id is required', 400);

        $customer = $this->customerService->showCustomer($id);
        response($customer, 200);
    }

    public function update()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_SANITIZE_NUMBER_INT, false);
        if (!$id) responseError('id is required', 400);

        $result = $this->customerService->updateCustomer($id, getBody());

        if ($result['success'] === true) {
            response(["message" => "Customer updated"], 200);
        } else {
            responseError("Unable to update", 400);
        }
        response($result, 200);
    }

    public function delete()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_SANITIZE_NUMBER_INT, false);
        if (!$id) responseError('id is required', 400);

        $this->customerService->deleteCustomer($id);
        response(['message' => ''], 204);
    }
}
