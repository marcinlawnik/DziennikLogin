<?php

class RoutesRespondProperlyTest extends TestCase
{
    public function testMainPageRespondsOK()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testLoginPageRespondsOK()
    {
        $crawler = $this->client->request('GET', '/users/login');

        $this->assertTrue($this->client->getResponse()->isOk());
    }
}
