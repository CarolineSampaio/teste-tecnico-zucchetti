<?php

class Order
{
    private $id, $customer_id, $payment_id, $installments, $order_id, $products;

    public function __construct($customer_id, $payment_id, $installments, $products)
    {
        $this->customer_id = $customer_id;
        $this->payment_id = $payment_id;
        $this->installments = $installments;
        $this->products = $products;
        # add finite state machine to control order status
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCustomerId()
    {
        return $this->customer_id;
    }
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
    }

    public function getPaymentId()
    {
        return $this->payment_id;
    }
    public function setPaymentId($payment_id)
    {
        $this->payment_id = $payment_id;
    }

    public function getInstallments()
    {
        return $this->installments;
    }
    public function setInstallments($installments)
    {
        $this->installments = $installments;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
    }

    public function getProducts()
    {
        return $this->products;
    }
    public function setProducts($products)
    {
        $this->products = $products;
    }
}
