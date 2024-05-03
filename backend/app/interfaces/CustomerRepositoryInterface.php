<?php

interface CustomerRepositoryInterface
{
    public function store($customer);
    public function index();
    public function show($id);
    public function update($id, $customer);
    public function delete($id);
}
