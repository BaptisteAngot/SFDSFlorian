<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeController extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    public function testGetFilmInexistant()
    {
        $client = static::createClient();

        $client->request('GET', '/movie/get/-551');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}