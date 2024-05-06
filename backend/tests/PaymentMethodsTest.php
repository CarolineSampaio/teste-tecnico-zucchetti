<?php

use Tests\TestBase;

class PaymentMethodsTest extends TestBase
{
    private function createPaymentMethod()
    {
        return self::$client->request("POST", "/payments", [
            "json" => [
                "name" => "credit_card",
                "max_installments" => 12
            ]
        ]);
    }

    public function testPaymentMethodsList()
    {
        $response = self::$client->request("GET", "/payments");
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
    }

    public function testPaymentMethodsCreate()
    {
        $response = self::createPaymentMethod();
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"message":"Registered successfully"}', $response->getBody());
    }

    public function testPaymentMethodsWithoutName()
    {
        $response = self::$client->request("POST", "/payments", [
            "json" => [
                "max_installments" => 12
            ]
        ]);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"error":"name is required"}', $response->getBody());
    }

    public function testGetPaymentMethod()
    {
        self::createPaymentMethod();
        $response = self::$client->request("GET", "/payments?id=1");
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
        $this->assertStringContainsString("credit_card", $response->getBody());
    }

    public function testUpdatePaymentMethod()
    {
        self::createPaymentMethod();
        $response = self::$client->request("PUT", "/payments?id=1", [
            "json" => [
                "name" => "pix",
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"message":"Payment method updated"}', $response->getBody());
    }

    public function testDeletePaymentMethod()
    {
        self::createPaymentMethod();
        $response = self::$client->request("DELETE", "/payments?id=1");
        $this->assertEquals(204, $response->getStatusCode());
    }
}
