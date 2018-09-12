<?php
/**
 * Created by PhpStorm.
 * User: pdolinaj
 * Date: 12/09/18
 * Time: 11:16
 */

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class ApiTestCase extends TestCase
{
    private static $staticClient;

    /**
     * @var Client
     */
    protected $client;

    public static function setUpBeforeClass()
    {
        self::$staticClient = new Client([
            'base_uri' => 'http://rest-symfony4.local'
        ]);
    }

    protected function setUp()
    {
        $this->client = self::$staticClient;
    }
}