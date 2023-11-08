<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddNewGameTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('newnew@gmail.com');

        $client->loginUser($testUser);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Add a new game');

        $history = $client->getHistory();
        $cookieJar = $client->getCookieJar();

        dump($history, $cookieJar);
    }
}
