<?php

declare(strict_types=1);

namespace Hyperdrive\Pilot;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Hyperdrive\Pilot\Pilot;
use Nette\Utils\ArrayList;


class Party
{

    protected Collection $pilots;

    /**
     * Party constructor.
     */
    public function __construct()
    {
        $this->pilots = collect();
    }

    public function addPilot(Pilot $pilot): void
    {
        $this->pilots->add($pilot);

    }

    public function addPilots(): void
    {
        $this->addPilot(new Pilot("Mark",0,1));
        $this->addPilot(new Pilot("Jack",2,3));
        $this->addPilot(new Pilot("John",4,5));
    }

    /**
     * @return Collection
     */
    public function getPilots(): Collection
    {
        return $this->pilots;
    }



}
