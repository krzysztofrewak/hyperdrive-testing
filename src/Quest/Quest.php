<?php

declare(strict_types=1);

namespace Hyperdrive\Quest;

use Hyperdrive\Geography\Planet;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Boolean;


class Quest
{
    protected Cargo $cargo;
    protected Planet $destination;
    protected Boolean $completed = false;

    /**
     * Quest constructor.
     * @param Cargo $cargo
     * @param Planet $destination
     * @param bool $completed
     */
    public function __construct(Cargo $cargo, Planet $destination, bool $completed)
    {
        $this->cargo = $cargo;
        $this->destination = $destination;
        $this->completed = $completed;
    }


    /**
     * @return Cargo
     */
    public function getCargo(): Cargo
    {
        return $this->cargo;
    }

    /**
     * @param Cargo $cargo
     */
    public function setCargo(Cargo $cargo): void
    {
        $this->cargo = $cargo;
    }

    /**
     * @return Planet
     */
    public function getDestination(): Planet
    {
        return $this->destination;
    }

    /**
     * @param Planet $destination
     */
    public function setDestination(Planet $destination): void
    {
        $this->destination = $destination;
    }




}
