<?php

use Tests\TestBase;

class ProductsTest extends TestBase
{
    private function createProduct()
    {
        return self::$client->request("POST", "/products", [
            "json" => [
                "name" => "produto3",
                "price" => 10.10,
                "quantity" => 50
            ]
        ]);
    }

    public function testProductsList()
    {
        $response = self::$client->request("GET", "/products");
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
    }

    public function testProductCreate()
    {
        $response = self::createProduct();
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"message":"Registered successfully"}', $response->getBody());
    }

    public function testProductWithoutName()
    {
        $response = self::$client->request("POST", "/products", [
            "json" => [
                "price" => 10.10,
                "quantity" => 50
            ]
        ]);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"error":"name is required"}', $response->getBody());
    }

    public function testGetProduct()
    {
        self::createProduct();
        $response = self::$client->request("GET", "/products?id=1");
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
        $this->assertStringContainsString("produto3", $response->getBody());
    }

    public function testUpdateProduct()
    {
        self::createProduct();
        $response = self::$client->request("PUT", "/products?id=1", [
            "json" => [
                "name" => "produto4",
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"message":"Product updated"}', $response->getBody());
    }

    public function testDeleteProduct()
    {
        self::createProduct();
        $response = self::$client->request("DELETE", "/products?id=1");
        $this->assertEquals(204, $response->getStatusCode());
    }
}
