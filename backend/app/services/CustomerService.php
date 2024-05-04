<?php
require_once '../app/repositories/CustomerRepository.php';

class CustomerService
{
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function createCustomer($body)
    {
        $validationRules = [
            'name' => FILTER_SANITIZE_SPECIAL_CHARS,
            'email' => FILTER_VALIDATE_EMAIL,
            'cpf' => FILTER_SANITIZE_SPECIAL_CHARS,
            'cep' => FILTER_SANITIZE_NUMBER_INT,
            'street' => FILTER_SANITIZE_SPECIAL_CHARS,
            'number' => FILTER_SANITIZE_SPECIAL_CHARS,
            'complement' => FILTER_SANITIZE_SPECIAL_CHARS,
            'neighborhood' => FILTER_SANITIZE_SPECIAL_CHARS,
            'city' => FILTER_SANITIZE_SPECIAL_CHARS,
            'state' => FILTER_SANITIZE_SPECIAL_CHARS
        ];

        $errors = [];
        foreach ($validationRules as $field => $filter) {
            $value = sanitizeInput($body, $field, $filter);
            if (!$value) {
                $errors[] = "$field is required";
            }
        }

        if (!empty($errors)) {
            responseError(implode(', ', $errors), 400);
        }

        $customer = new Customer(
            $body->name,
            $body->email,
            $body->cpf,
            $body->cep,
            $body->street,
            $body->number,
            $body->complement,
            $body->neighborhood,
            $body->city,
            $body->state
        );

        $response = $this->customerRepository->createOne($customer);

        return $response;
    }

    public function listAllCustomers()
    {
        return $this->customerRepository->getAll();
    }

    public function showCustomer($id)
    {
        $customer = $this->customerRepository->getOne($id);
        if (!$customer) responseError('Customer not found', 404);

        return $customer;
    }

    public function updateCustomer($id, $body)
    {
        $customer = $this->customerRepository->getOne($id);
        if (!$customer) responseError('Customer not found', 404);

        $validationRules = [
            'name' => FILTER_SANITIZE_SPECIAL_CHARS,
            'email' => FILTER_VALIDATE_EMAIL,
            'cpf' => FILTER_SANITIZE_SPECIAL_CHARS,
            'cep' => FILTER_SANITIZE_NUMBER_INT,
            'street' => FILTER_SANITIZE_SPECIAL_CHARS,
            'number' => FILTER_SANITIZE_SPECIAL_CHARS,
            'complement' => FILTER_SANITIZE_SPECIAL_CHARS,
            'neighborhood' => FILTER_SANITIZE_SPECIAL_CHARS,
            'city' => FILTER_SANITIZE_SPECIAL_CHARS,
            'state' => FILTER_SANITIZE_SPECIAL_CHARS
        ];

        $errors = [];
        foreach ($validationRules as $field => $filter) {
            if (isset($body->$field)) {
                $value = sanitizeInput($body, $field, $filter);
                if (!$value) {
                    $errors[] = "$field is invalid";
                }
            }
        }

        if (!empty($errors)) {
            responseError(implode(', ', $errors), 400);
        }

        $response = $this->customerRepository->updateOne($id, $body);

        return $response;
    }

    public function deleteCustomer($id)
    {
        $customer = $this->customerRepository->getOne($id);
        if (!$customer) responseError('Customer not found', 404);

        return $this->customerRepository->deleteOne($id);
    }
}
