<?php

declare(strict_types=1);

namespace Hyperdrive\Geography;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class Planet
 * @package Hyperdrive\Geography
 * @var Planet[] $neighbours
 */
class Planet
{
    protected Collection $neighbours;

    public function __construct(
        protected string $name
    ) {
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

    public function getId(): string
    {
        return Str::slug($this->name);
    }

    public function addNeighbour(self $planet): void
    {
        $this->neighbours->add($planet);
    }
}
