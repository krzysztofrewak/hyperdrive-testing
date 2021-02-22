<?php

declare(strict_types=1);

namespace Hyperdrive\GameSave;

trait IntegrityController
{
    public function toggleInGameState(): void
    {
        $_SESSION['isInGame'] = !$_SESSION['isInGame'];
    }

    public function canStartGame(): bool
    {
        return !$this->isGameRunning();
    }

    private function isGameRunning(): bool
    {
        return $_SESSION['isInGame'];
    }
}