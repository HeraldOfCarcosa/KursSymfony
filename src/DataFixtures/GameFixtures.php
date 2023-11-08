<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class GameFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $game = new Game();
            $game->setName('Game'.$i)
                ->setDescription('TYPICAL DESCRIPTION' .$i)
                ->setReleaseDate(new \DateTime('now'))
                ->setScore(random_int(0, 10));

        }
        $manager->persist($game);

        $manager->flush();
    }
}
