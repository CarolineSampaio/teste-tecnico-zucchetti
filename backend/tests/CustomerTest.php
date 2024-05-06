<?php

use Tests\TestBase;

class CustomerTest extends TestBase
{
    private function createCustomer()
    {
        return self::$client->request("POST", "/customers", [
            "json" => [
                "name" => "João",
                "email" => "joao@example.com",
                "cpf" => "123.456.789-00",
                "cep" => "12345678",
                "street" => "Main Street",
                "number" => "123",
                "complement" => "Apartment 101",
                "neighborhood" => "Central",
                "city" => "Big City",
                "state" => "BC"
            ]
        ]);
    }

    public function testCustomerList()
    {
        $response = self::$client->request("GET", "/customers");
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
    }

    public function testCustomerCreate()
    {
        $response = self::createCustomer();
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"message":"Registered successfully"}', $response->getBody());
    }

    public function testCustomerWithoutName()
    {
        $response = self::$client->request("POST", "/customers", [
            "json" => [
                "email" => "joao@example.com",
                "cpf" => "123.456.789-00",
                "cep" => "12345678",
                "street" => "Main Street",
                "number" => "123",
                "complement" => "Apartment 101",
                "neighborhood" => "Central",
                "city" => "Big City",
                "state" => "BC"
            ]
        ]);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"error":"name is required"}', $response->getBody());
    }

    public function testGetCustomer()
    {
        self::createCustomer();
        $response = self::$client->request("GET", "/customers?id=1");
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
        $this->assertStringContainsString("joao@example.com", $response->getBody());
    }

    public function testUpdateCustomer()
    {
        self::createCustomer();
        $response = self::$client->request("PUT", "/customers?id=1", [
            "json" => [
                "email" => "another@example.com"
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"message":"Customer updated"}', $response->getBody());
    }

    public function testDeleteCustomer()
    {
        self::createCustomer();
        $response = self::$client->request("DELETE", "/customers?id=1");
        $this->assertEquals(204, $response->getStatusCode());
    }
}
