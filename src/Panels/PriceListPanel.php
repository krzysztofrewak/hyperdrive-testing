<?php

declare(strict_types=1);

namespace Hyperdrive\Panels;

use Hyperdrive\Panels\PriceListResources\FuelResource;
use Hyperdrive\Panels\PriceListResources\HyperspaceJumpResource;
use Hyperdrive\Panels\PriceListResources\MapResource;
use Hyperdrive\PriceList\PriceList;

class PriceListPanel extends BasePanel
{
    protected int $mapPrice;
    protected array $fuelPrice;
    protected array $hyperspaceJumpOptions;

    public function __construct()
    {
        parent::__construct();
        $this->fuelPrice = PriceList::getFuelValues();
        $this->mapPrice = PriceList::getMapPrice();
        $this->hyperspaceJumpOptions = PriceList::getHyperspaceJumpOptions();
    }

    public function show(): void
    {
        $table = $this->createTable();
        $this->cli->table($table);
    }

    private function createTable(): array
    {
        $collection = collect();

        $fuelResource = new FuelResource();
        $mapResource = new MapResource();
        $hyperspaceJumpResource = new HyperspaceJumpResource();

        $collection->add($fuelResource($this->fuelPrice));
        $collection->add($mapResource($this->mapPrice));

        foreach ($this->hyperspaceJumpOptions as $jumpOption) {
            $collection->add($hyperspaceJumpResource($jumpOption));
        }

        return $collection->toArray();
    }
}
