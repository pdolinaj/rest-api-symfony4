<?php
/**
 * Created by PhpStorm.
 * User: pdolinaj
 * Date: 12/09/18
 * Time: 11:07
 */
namespace App\Tests\Controller\Api;

use App\Tests\ApiTestCase;

class TeamsControllerTest extends ApiTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    public function testPOST()
    {
        $data = array(
            'name' => 'New Team',
            'strip' => 'New Strip',
            'league' => 1
        );

        $token = self::$kernel->getContainer()
            ->get('lexik_jwt_authentication.encoder')
            ->encode(['username' => 'king']);

        $response = $this->client->post('/api/v1/teams', [
            'form_params' => $data,
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        //check whether the Team has been created
        $teamResponse = $this->client->get(current($response->getHeader('Location')), [
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);
        $this->assertEquals(200, $teamResponse->getStatusCode());

        $teamData = json_decode($teamResponse->getBody(), true);

        $this->assertArrayHasKey('data', $teamData);
        $this->assertArrayHasKey('status', $teamData);

        $this->assertEquals('New Team', $teamData['data']['team']['name']);
        $this->assertEquals('New Strip', $teamData['data']['team']['strip']);
        $this->assertEquals(1, $teamData['data']['league']['id']);
    }


    public function testPUTTeam()
    {
        $data = array(
            'name' => 'AFC Bournemouth - updated',
            'strip' => 'AFC Bournemouth - updated',
            'league' => 1
        );

        $token = self::$kernel->getContainer()
            ->get('lexik_jwt_authentication.encoder')
            ->encode(['username' => 'king']);

        // Create a team resource
        $response = $this->client->put('/api/v1/teams/1', [
            'body' => json_encode($data),
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        //check whether the Team has been updated
        $teamResponse = $this->client->get('/api/v1/teams/1', [
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);
        $this->assertEquals(200, $teamResponse->getStatusCode());

        $teamData = json_decode($teamResponse->getBody(), true);

        $this->assertArrayHasKey('data', $teamData);
        $this->assertArrayHasKey('status', $teamData);

        $this->assertEquals('AFC Bournemouth - updated', $teamData['data']['team']['name']);
        $this->assertEquals('AFC Bournemouth - updated', $teamData['data']['team']['strip']);
        $this->assertEquals(1, $teamData['data']['league']['id']);
    }
}
