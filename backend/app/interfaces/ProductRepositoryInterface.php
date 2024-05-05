<?php

interface ProductRepositoryInterface
{
    public function createOne($product);
    public function getAll();
    public function getOne($id);
    public function updateOne($id, $product);
    public function deleteOne($id);
}
