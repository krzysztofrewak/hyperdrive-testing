<?php

declare(strict_types=1);

namespace Hyperdrive\Panels;

use Hyperdrive\PriceList\PriceList;
use Hyperdrive\Resources\PriceList\FuelResource;
use Hyperdrive\Resources\PriceList\HyperspaceJumpResource;
use Hyperdrive\Resources\PriceList\MapResource;

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
        $table = collect();

        $fuelResource = new FuelResource();
        $mapResource = new MapResource();
        $hyperspaceJumpResource = new HyperspaceJumpResource();

        $table->add($fuelResource($this->fuelPrice));
        $table->add($mapResource($this->mapPrice));

        foreach ($this->hyperspaceJumpOptions as $jumpOption) {
            $table->add($hyperspaceJumpResource($jumpOption));
        }

        return $table->toArray();
    }
}
