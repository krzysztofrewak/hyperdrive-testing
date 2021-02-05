<?php

declare(strict_types=1);

namespace Hyperdrive\Interfaces;


use Hyperdrive\Entity\Person;
use Hyperdrive\Ship\SpaceShip;

interface TasksInterface
{
    public function choosePrize(SpaceShip $ship, Person $person);
    public function missionStatement(SpaceShip $ship, Person $person);
}