<?php
/**
 * Created by PhpStorm.
 * User: pdolinaj
 * Date: 12/09/18
 * Time: 11:16
 */

namespace App\Tests;

//Access Services: https://symfony.com/blog/new-in-symfony-4-1-simpler-service-testing
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use GuzzleHttp\Client;

class ApiTestCase extends WebTestCase
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
        self::bootKernel();

        $this->client = self::$staticClient;
    }
}