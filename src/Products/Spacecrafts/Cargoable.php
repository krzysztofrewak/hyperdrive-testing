<?php

declare(strict_types=1);

namespace Hyperdrive\Products\Spacecrafts;

use Hyperdrive\Exceptions\NotEnoughCargoSpace;
use Hyperdrive\Wares\Commodity;

trait Cargoable
{
    protected ?Commodity $cargoSpace;
    protected int $maxCargoSpaceWeight;

    public function getMaxCargoSpaceWeight(): int
    {
        return $this->maxCargoSpaceWeight;
    }

    public function loadCommodity(Commodity $commodity): void
    {
        if ($commodity->getCompleteWeight() <= $this->maxCargoSpaceWeight) {
            $this->cargoSpace = $commodity;
        }else {
            throw new NotEnoughCargoSpace("Not enough cargo space");
        }
    }

    public function unloadCommodity(string $type): Commodity
    {
        $commodity = $this->cargoSpace;
        $this->cargoSpace = null;
        return $commodity;
    }
}
