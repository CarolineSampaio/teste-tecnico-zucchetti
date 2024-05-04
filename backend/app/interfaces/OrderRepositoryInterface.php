<?php

interface OrderRepositoryInterface
{
    public function decreaseInventory($product);
    public function getProductsTotal($products);
    public function getProductPrice($productId);

    public function storeOrder($order);
    public function storeOrderDetail($order);
    public function registerOrder($order);

    public function getAll();
    public function getOne($id);
    public function getOneByCustomerId($customerId);
    public function updateOne($id, $order);
    public function deleteOne($id);
}
