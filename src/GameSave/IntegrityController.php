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

    public function canStartGame(): bool
    {
        if ($this->isSaveGameCorrect() && !$this->isGameRunning()) {
            return true;
        } else {
            return false;
        }
    }

    private function isSaveGameCorrect(): bool
    {
        return true;
    }

    private function isGameRunning(): bool
    {
        return false;
    }
}