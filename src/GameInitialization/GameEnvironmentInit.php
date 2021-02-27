<?php

declare(strict_types=1);

namespace Hyperdrive\GameInitialization;

class GameEnvironmentInit
{
    public function __construct()
    {
        $_SESSION['language'] = 'en';
        $_SESSION['saveFile'] = '/application/gamesave';
        $_SESSION['isInGame'] = false;
        $_SESSION['isMissionComplete'] = false;
        $_SESSION['nextMission'] = "";
        new MainMenu();
    }
}