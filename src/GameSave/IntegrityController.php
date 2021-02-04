<?php

declare(strict_types=1);

namespace Hyperdrive\GameSave;

use Hyperdrive\GameSave;

trait IntegrityController
{
    public function addAssetsIdsToSaveFile(array $planets): void
    {
        $this->gameSave->targetPlanet = $planets[0]->getId();
        $this->gameSave->currentPlanet = $planets[1]->getId();
    }
}