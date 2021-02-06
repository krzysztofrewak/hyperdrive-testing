<?php

declare(strict_types=1);

namespace Hyperdrive\GameSave;

trait IntegrityController
{
    public function toggleInGameState(): void
    {
        $state = $_SESSION['isInGame'];
        $_SESSION['isInGame'] = abs($state <=> 1);
    }
}