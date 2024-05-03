<?php

class Customer
{
    private $id, $name, $email, $cpf, $cep, $street, $number, $complement, $neighborhood, $city, $state;

    public function __construct($name, $email, $cpf, $cep, $street, $number, $complement, $neighborhood, $city, $state)
    {
        $this->name = $name;
        $this->email = $email;
        $this->cpf = $cpf;
        $this->cep = $cep;
        $this->street = $street;
        $this->number = $number;
        $this->complement = $complement;
        $this->neighborhood = $neighborhood;
        $this->city = $city;
        $this->state = $state;
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

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getCpf()
    {
        return $this->cpf;
    }
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function getCep()
    {
        return $this->cep;
    }
    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    public function getStreet()
    {
        return $this->street;
    }
    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function getNumber()
    {
        return $this->number;
    }
    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function getComplement()
    {
        return $this->complement;
    }
    public function setComplement($complement)
    {
        $this->complement = $complement;
    }

    public function getNeighborhood()
    {
        return $this->neighborhood;
    }
    public function setNeighborhood($neighborhood)
    {
        $this->neighborhood = $neighborhood;
    }

    public function getCity()
    {
        return $this->city;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getState()
    {
        return $this->state;
    }
    public function setState($state)
    {
        $this->state = $state;
    }
}
