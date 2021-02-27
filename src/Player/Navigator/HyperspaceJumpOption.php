<?php

declare(strict_types=1);

namespace Hyperdrive\Player\Navigator;

class HyperspaceJumpOption
{
    public function __construct(protected string $name, protected int $distance, protected int $price)
    {
    }

    public function __toString(): string
    {
        return $this->name . " jump - {$this->distance} planets";
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
