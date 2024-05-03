<?php
require_once '../app/repositories/PaymentMethodRepository.php';

class PaymentMethodService
{
    private $paymentMethodRepository;

    public function __construct(PaymentMethodRepository $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function createPaymentMethod($data)
    {
        $validationRules = [
            'name' => FILTER_SANITIZE_SPECIAL_CHARS,
            'max_installments' => FILTER_SANITIZE_NUMBER_INT
        ];

        $errors = [];
        foreach ($validationRules as $field => $filter) {
            $value = sanitizeInput($data, $field, $filter);
            if (!$value) {
                $errors[] = "$field is required";
            }
        }

        if (!empty($errors)) {
            responseError(implode(', ', $errors), 400);
        }

        $paymentMethod = new PaymentMethod(
            $data->name,
            $data->max_installments
        );

        $response = $this->paymentMethodRepository->store($paymentMethod);

        return $response;
    }

    public function listAllPaymentMethods()
    {
        return $this->paymentMethodRepository->index();
    }

    public function showPaymentMethod($id)
    {
        $paymentMethod = $this->paymentMethodRepository->show($id);
        if (!$paymentMethod) responseError('Payment method not found', 404);

        return $paymentMethod;
    }

    public function updatePaymentMethod($id, $body)
    {
        $paymentMethod = $this->paymentMethodRepository->show($id);
        if (!$paymentMethod) responseError('Payment method not found', 404);

        $validationRules = [
            'name' => FILTER_SANITIZE_SPECIAL_CHARS,
            'max_installments' => FILTER_SANITIZE_NUMBER_INT
        ];

        $errors = [];
        foreach ($validationRules as $field => $filter) {
            if (isset($body->$field)) {
                $value = sanitizeInput($body, $field, $filter);
                if (!$value) {
                    $errors[] = "$field is required";
                }
            }
        }

        if (!empty($errors)) {
            responseError(implode(', ', $errors), 400);
        }

        $response = $this->paymentMethodRepository->update($id, $body);

        return $response;
    }

    public function deletePaymentMethod($id)
    {
        $paymentMethod = $this->paymentMethodRepository->show($id);
        if (!$paymentMethod) responseError('Payment method not found', 404);

        return $this->paymentMethodRepository->delete($id);
    }
}
