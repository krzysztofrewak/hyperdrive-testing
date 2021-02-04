<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

use Hyperdrive\GameSave;
use Hyperdrive\GameSave\IntegrityController;

// this class should receive NewGame or ResumeGame classes
// and then build all the game assets
class Game
{
    // consider putting setGlobalSettings to the trait below
    use IntegrityController;

    public GameSave $gameSave;
    private GameAssetsBuilder $builder;

    public function __construct(GameSave $gameSave)
    {
        $this->gameSave = $gameSave;
        $this->builder = new GameAssetsBuilder();
        $this->addAssetsIdsToSaveFile($this->builder->getAssetsIdsToSaveFile());
        $this->setGlobalSettings();
    }

    private function setGlobalSettings(): void
    {
        $_SESSION['isInGame'] = 1;
    }
}