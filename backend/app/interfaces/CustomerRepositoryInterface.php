<?php

interface CustomerRepositoryInterface
{
    public function createOne($customer);
    public function getAll();
    public function getOne($id);
    public function updateOne($id, $customer);
    public function deleteOne($id);
}
