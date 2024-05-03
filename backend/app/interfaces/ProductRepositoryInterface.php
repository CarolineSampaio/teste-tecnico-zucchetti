<?php

interface ProductRepositoryInterface
{
    public function store($product);
    public function index();
    public function show($id);
    public function update($id, $product);
    public function delete($id);
}
