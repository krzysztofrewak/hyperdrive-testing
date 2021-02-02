<?php

declare(strict_types=1);

namespace Hyperdrive\Quest;

use Hyperdrive\Geography\Planet;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Boolean;


class Quest
{
    private Cargo $cargo;
    private Planet $destination;
    private Bool $completed = false;

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


    public function completionToString() :string
    {
        if($this->isCompleted() == false){
            return "No";
        }
        else{
            return "Yes";
        }
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

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->completed;
    }

    /**
     * @param bool $completed
     */
    public function setCompleted(bool $completed): void
    {
        $this->completed = $completed;
    }





}
