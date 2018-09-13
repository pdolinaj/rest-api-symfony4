<?php
/**
 * Created by PhpStorm.
 * User: pdolinaj
 * Date: 12/09/18
 * Time: 11:07
 */
namespace App\Tests\Controller\Api;

use App\Tests\ApiTestCase;

class TokenControllerTest extends ApiTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    public function testPOSTCreateToken()
    {
        $this->createUser('superuser', 'superpassword');
        $response = $this->client->post('/token', [
            'auth' => ['superuser', 'superpassword']
        ]);

        $data = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertArrayHasKey('token', $data);
    }
}