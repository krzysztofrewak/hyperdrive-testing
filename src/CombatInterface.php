<?php

namespace Hyperdrive;

interface CombatInterface
{
    public function shoot(Being $being): void;

    public function getSpecialization(): string;

    public function applyBonus(int $value, string $type): void;
}