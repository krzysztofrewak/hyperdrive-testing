<?php

declare(strict_types=1);

namespace Hyperdrive\Galaxy\Geography;

use Hyperdrive\Traits\Identifier;
use Illuminate\Support\Collection;

/**
 * Class Planet
 * @package Hyperdrive\Galaxy\Geography
 * @var Planet[] $neighbours
 */
class Planet
{
    use Identifier;

    protected Collection $neighbours;

    public function __construct(protected string $name)
    {
        $this->neighbours = collect();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getNeighbours(): Collection
    {
        return $this->neighbours;
    }

    public function addNeighbour(self $planet): void
    {
        $this->neighbours->add($planet);
    }
}
