<?php

interface PaymentMethodRepositoryInterface
{
    public function store($paymentMethod);
    public function index();
    public function show($id);
    public function update($id, $paymentMethod);
    public function delete($id);
}
