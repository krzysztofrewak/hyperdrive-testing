<?php

declare(strict_types=1);

namespace Hyperdrive\Player\Pilot;

class Pilot
{
    protected string $name;

    public function __construct(array $pilotData)
    {
        $this->setPilotData($pilotData);
    }

    public function __toString(): string
    {
        return $this->name;
    }

    private function setPilotData(array $pilotData): void
    {
        $this->name = $pilotData["name"];
    }
}
