<?php

class PaymentMethod
{
    private $id, $name, $max_installments;

    public function __construct($name, $max_installments)
    {
        $this->name = $name;
        $this->max_installments = $max_installments;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getMaxInstallments()
    {
        return $this->max_installments;
    }
    public function setMaxInstallments($max_installments)
    {
        $this->max_installments = $max_installments;
    }
}
