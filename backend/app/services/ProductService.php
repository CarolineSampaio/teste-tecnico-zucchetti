<?php
require_once '../app/repositories/ProductRepository.php';

class ProductService
{

    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct($body)
    {
        $validationRules = [
            'name' => FILTER_SANITIZE_SPECIAL_CHARS,
            'price' => FILTER_SANITIZE_NUMBER_FLOAT,
            'quantity' => FILTER_SANITIZE_NUMBER_INT
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

        $product = new Product(
            $body->name,
            $body->price,
            $body->quantity
        );

        $response = $this->productRepository->store($product);

        return $response;
    }

    public function listAllProducts()
    {
        return $this->productRepository->index();
    }

    public function showProduct($id)
    {
        $product = $this->productRepository->show($id);
        if (!$product) responseError('Product not found', 404);

        return $product;
    }

    public function updateProduct($id, $body)
    {
        $product = $this->productRepository->show($id);
        if (!$product) responseError('Product not found', 404);

        $validationRules = [
            'name' => FILTER_SANITIZE_SPECIAL_CHARS,
            'price' => FILTER_SANITIZE_NUMBER_FLOAT,
            'quantity' => FILTER_SANITIZE_NUMBER_INT
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

        $response = $this->productRepository->update($id, $body);

        return $response;
    }

    public function deleteProduct($id)
    {
        $product = $this->productRepository->show($id);
        if (!$product) responseError('Product not found', 404);

        return $this->productRepository->delete($id);
    }
}
