<?php

namespace AppBundle\Tests\Controller\API;

use AppBundle\Tests\ApiTestCase;

class ProgrammerControllerTest extends ApiTestCase
{

    public function testPOST()
    {
        $nickname = 'ObjectOrienter' . rand(0, 999);
        $data = [
            'nickname'     => 'ObjectOrienter',
            'avatarNumber' => 5,
            'tagLine'      => 'a test dev!'
        ];

        // 1) POST to create the programmer
        $response = $this->client->post('/api/programmers', [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));
        $finishedData = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('nickname', $finishedData);
        $this->assertEquals('ObjectOrienter', $finishedData['nickname']);
    }
}
