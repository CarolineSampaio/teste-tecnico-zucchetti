<?php

require_once '../models/Product.php';
require_once '../services/ProductService.php';
require_once '../repositories/ProductRepository.php';
require_once '../../utils.php';

class ProductController
{
    private $productService;

    public function __construct()
    {
        $repository = new ProductRepository();
        $this->productService = new productService($repository);
    }

    public function store()
    {
        $body = getBody();

        $response = $this->productService->createProduct($body);

        if ($response['success'] === true) {
            response(["message" => 'Registered successfully'], 201);
        } else {
            responseError('Unable to register', 400);
        }
    }

    public function index()
    {
        $products = $this->productService->listAllProducts();
        response($products, 200);
    }

    public function show()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_SANITIZE_NUMBER_INT, false);
        if (!$id) responseError('id is required', 400);

        $product = $this->productService->showProduct($id);
        response($product, 200);
    }

    public function update()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_SANITIZE_NUMBER_INT, false);
        if (!$id) responseError('id is required', 400);

        $result = $this->productService->updateProduct($id, getBody());

        if ($result['success'] === true) {
            response(["message" => "Product updated"], 201);
        } else {
            responseError("Unable to update", 400);
        }
    }

    public function delete()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_SANITIZE_NUMBER_INT, false);
        if (!$id) responseError('id is required', 400);

        $this->productService->deleteProduct($id);
        response(['message' => ''], 204);
    }
}
