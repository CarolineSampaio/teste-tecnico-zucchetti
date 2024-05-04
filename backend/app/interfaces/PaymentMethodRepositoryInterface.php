<?php

interface PaymentMethodRepositoryInterface
{
    public function createOne($paymentMethod);
    public function getAll();
    public function getOne($id);
    public function updateOne($id, $paymentMethod);
    public function deleteOne($id);
}
