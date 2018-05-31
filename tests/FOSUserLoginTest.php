<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FOSUserLoginTest extends WebTestCase
{

    public function testLogin()
    {
        $client = static::createClient();
        $homePage = $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $redirectPage = $client->getCrawler();
        $link = $redirectPage->filter('.loginLink')->link();
        $redirectPage = $client->click($link);

        $loginForm = $redirectPage->filter('.form-signin')->count();

        $this->assertEquals('1', $loginForm);
    }
}
