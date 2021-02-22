<?php

declare(strict_types=1);

namespace Hyperdrive\Game\Resume;

use Hyperdrive\BaseGameType;
use Hyperdrive\GameSave;

class ResumeGame extends BaseGameType
{
    public function __construct()
    {
        $this->gameSave = new GameSave();
        $this->deserialize();
    }
}