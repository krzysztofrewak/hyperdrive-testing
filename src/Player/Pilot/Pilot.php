<?php

declare(strict_types=1);

namespace Hyperdrive\Player\Pilot;

class Pilot
{
    public function __construct(protected string $name)
    {
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
