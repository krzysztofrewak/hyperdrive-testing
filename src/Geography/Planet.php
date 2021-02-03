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
    protected int $price;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->neighbours = collect();
        $this->price = rand(1,3);
    }

    public function __toString(): string
    {
        return $this->name." price: ".$this->price;
    }

    public function getName(): string
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

    public function getPrice(): int
    {
        return $this->price;
    }






}
