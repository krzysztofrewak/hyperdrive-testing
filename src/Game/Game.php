<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

use Hyperdrive\GameSave;
use Hyperdrive\GameSave\IntegrityController;

class Game
{
    use IntegrityController;

    public GameSave $gameSave;
    private GameAssetsBuilder $builder;

    public function __construct(GameSave $gameSave)
    {
        $this->gameSave = $gameSave;
        $this->builder = new GameAssetsBuilder();
        $this->toggleInGameState();
    }
}