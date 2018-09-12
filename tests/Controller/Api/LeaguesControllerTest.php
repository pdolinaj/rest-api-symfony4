<?php
/**
 * Created by PhpStorm.
 * User: pdolinaj
 * Date: 12/09/18
 * Time: 11:07
 */
namespace App\Tests\Controller\Api;

use App\Tests\ApiTestCase;


class LeaguesControllerTest extends ApiTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    public function testGETTeams()
    {
        //existing league
        $response = $this->client->get('api/v1/leagues/1');
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertGreaterThan(1, count($data['data']));
    }

    public function testDELETELeague()
    {
        $response = $this->client->delete('api/v1/leagues/3', [
            'http_errors' => false
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
