<?php

use Tests\TestBase;

class OrdersTest extends TestBase
{
    private function createPaymentMethod(): void
    {
        self::$client->request("POST", "/payments", [
            "json" => [
                "name" => "credit_card",
                "max_installments" => 12
            ]
        ]);
        self::$client->request("POST", "/payments", [
            "json" => [
                "name" => "pix",
                "max_installments" => 1
            ]
        ]);
    }

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

    private function createProduct()
    {
        return self::$client->request("POST", "/products", [
            "json" => [
                "name" => "TV",
                "price" => 10.10,
                "quantity" => 50
            ]
        ]);
    }

    private function createOrder()
    {
        self::createPaymentMethod();
        self::createCustomer();
        self::createProduct();
        return self::$client->request("POST", "/orders", [
            "json" => [
                "customer_id" => 1,
                "payment_id" => 1,
                "installments" => 5,
                "products" => [
                    [
                        "product_id" => 1,
                        "quantity" => 10
                    ]
                ]
            ]
        ]);
    }

    public function testOrderList()
    {
        $response = self::$client->request("GET", "/orders");
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
    }

    public function testOrderCreate()
    {
        $response = self::createOrder();
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"message":"Registered successfully"}', $response->getBody());
    }

    public function testOrderWithoutCustomer_id()
    {
        $response = self::$client->request("POST", "/orders", [
            "json" => [
                "payment_id" => 1,
                "installments" => 5,
                "products" => [
                    [
                        "product_id" => 1,
                        "quantity" => 10
                    ]
                ]
            ]
        ]);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"error":"customer_id is required"}', $response->getBody());
    }

    public function testGetOrder()
    {
        self::createOrder();
        $response = self::$client->request("GET", "/orders?id=1");
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
        $this->assertStringContainsString("credit_card", $response->getBody());
        $this->assertStringContainsString("TV", $response->getBody());
        $this->assertStringContainsString('"total":"101"', $response->getBody());
    }

    public function testGetOrderByCustomerId()
    {
        self::createOrder();
        $response = self::$client->request("GET", "/orders?customer_id=1");
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
        $this->assertStringContainsString("credit_card", $response->getBody());
        $this->assertStringContainsString("TV", $response->getBody());
        $this->assertStringContainsString('"total":"101"', $response->getBody());
    }


    public function testUpdateOrder()
    {
        self::createOrder();
        $response = self::$client->request("PUT", "/orders?id=1", [
            "json" => [
                "payment_id" => 2,
                "installments" => 1,
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"message":"Order updated"}', $response->getBody());
    }

    public function testDeleteOrder()
    {
        self::createOrder();
        $response = self::$client->request("DELETE", "/orders?id=1");
        $this->assertEquals(204, $response->getStatusCode());
    }
}
