<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestNewGameTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('userADD@op.pl');

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/games/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Add new game');
    }
    public function testFormSubmitAddsNewGame(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('userADD@op.pl');
        $client->loginUser($testUser);
        $client->request('GET', '/games/new');

        $client->submitForm('Save', [
            'game[name]' => 'Test game',
            'game[description]' => 'Test description',
            'game[releaseDate]' => '2023-01-01',
            'game[score]' => 10,
        ]);
        $client->followRedirect();

        // assert that we are on the game page
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Test game');
    }
}
