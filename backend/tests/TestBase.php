<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;
use GuzzleHttp\Client;

require_once "app/models/Database.php";

class TestBase extends TestCase
{
    private static $process;
    public static $client;

    public static function setUpBeforeClass(): void
    {
        $url = "localhost:8080";
        self::$process = new Process(["php", "-S",  $url,  "-t", "./public"]);
        self::$process->start();
        usleep(100000); # espera 100ms para o servidor iniciar
        self::$client = new Client([
            'http_errors' => false,
            'base_uri' => 'http://' . $url
        ]);
    }

    public static function tearDownAfterClass(): void
    {
        self::$process->stop();
    }

    public function setUp(): void
    {
        # limpa o banco de dados antes de cada teste
        $tables = ["orders", "customers", "products", "paymentMethods", "orderDetails"];
        $connection = (new \Database())->getConnection();
        foreach ($tables as $table) {
            $connection->exec("TRUNCATE TABLE $table RESTART IDENTITY CASCADE");
        }
    }
}
