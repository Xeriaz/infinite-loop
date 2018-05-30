<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FOSUserLoginTest extends WebTestCase
{

    /**
     * @param string $username
     * @param string $password
     * @dataProvider userDataInfo
     */
    public function testLogin(string $username, string $password)
    {
        $client = static::createClient();
        $homePage = $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $redirectPage = $client->getCrawler();
        $link = $redirectPage->filter('.loginLink')->link();
        $redirectPage = $client->click($link);

        try {
            $loginForm = $redirectPage->filter('.form-signin')->selectButton('Sign in')->form();

            $loginForm->setValues([
                '_username' => $username,
                '_password' => $password
            ]);

            $client->submit($loginForm);
        } catch (\InvalidArgumentException $e) {
            dump($e);
        }

        $this->assertSame(302, $client->getResponse()->getStatusCode());

        $signedInPage = $client->getCrawler();

        $login_check = ($signedInPage->filter('body a')->text());
        $link = $signedInPage->filter('body a')->link();
        $this->assertSame('http://localhost/', $login_check);

        $redirectToHome = $client->click($link);
        $logOutText = $redirectToHome->filter('body > header > nav > a:nth-child(4) > div > span')->text();
        $this->assertEquals('Log out', $logOutText);
    }

    public function userDataInfo()
    {
        return [
            ['demo1', 'demo'],
            ['demo2', 'demo'],
        ];
    }
}
