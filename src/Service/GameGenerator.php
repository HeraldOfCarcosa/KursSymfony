<?php

namespace App\Service;

class GameGenerator
{

    //private array $gameList;
    private $gameList = ['Hollow Knight', 'Stellaris', 'Darktide', 'Sekiro', 'Dark Souls', 'Elden Ring', 'Barotrauma', 'Terraria', 'Kerbal Space Program', 'Cyberpunk 2077'];
    /**

     * @param array $gameList
     */

    public function __construct(array $gameList)
    {
        $this->gameList = $gameList;
    }

    public function gameGeneration(): array
    {
        $arrayWithGames = [];
        
        while (count($arrayWithGames) < 5)
        {
            $game = $this->gameList[rand(0, count($this->gameList) - 1)];

            if (!in_array($game, $arrayWithGames)) {
                $arrayWithGames[] = $game;
            }
        }
        return $arrayWithGames;
    }


}