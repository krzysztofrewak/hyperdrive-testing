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
    protected string $name;
    protected Collection $neighbours;

    public function __construct(string $name)
    {
        $this->name = $name;
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
        if (!$this->neighbours->contains($planet->getId())) {
            $this->neighbours->add($planet);
        } else {
            echo "planet is already a friend" . PHP_EOL;
        }
    }
}
