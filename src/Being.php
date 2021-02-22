<?php

declare(strict_types=1);

namespace Hyperdrive;

class Being implements CombatInterface
{
    protected string $name;
    protected int $health = 100;
    protected int $weaponType;
    protected int $weaponStrength = 0;
    protected int $accuracy = 50;
    protected int $defence = 5;
    protected string $tag;
    protected ?string $specialization;
    protected ?int $bonus = null;

    public function __construct(string $name, int $coverBonus)
    {
        $this->name = $name;
        $this->defence += $coverBonus;
    }

    public function shoot(Being $being): void
    {
        $accuracy = $this->accuracy + rand(-10, 25);
        echo "Accuracy is $accuracy" . PHP_EOL;
        $being->beShootAt($accuracy, $this->weaponStrength);
    }

    private function beShootAt(int $accuracy, int $damageToReceive): void
    {
        echo "$this->name is being shot at" . PHP_EOL;

        $doesShotLand = rand(1, 100) <= $accuracy;

        if ($doesShotLand) {
            echo "Shot hits the target" . PHP_EOL;
            $this->updateHealth($damageToReceive - $this->defence);
        }
    }

    private function updateHealth(int $value): void
    {
        echo "Damage to deal $value" . PHP_EOL;
        $this->health -= abs($value);
        echo "$this->name has now $this->health";
    }

    protected function getWeaponType(int $strengthLevel): int
    {
        $goodWeaponChance = round($strengthLevel / ($strengthLevel + 1), 2) * 100;
        $condition = rand(1, 100) >= $goodWeaponChance;
        $weaponType = $condition ? 2 : 1;

        return $weaponType;
    }

    protected function getWeaponStrength(): int
    {
        return rand(1, 10) + $this->weaponType;
    }

    protected function setTag(string $type): void
    {
        $this->tag = $type;
    }

    protected function setSpecialization(string $type): void
    {
        $this->specialization = $type;
    }

    public function getSpecialization(): string
    {
        return $this->specialization;
    }

    public function applyBonus(int $value, string $type): void
    {
        if ($type === "defence") {
            $this->defence += $value;
        }

        if ($type === "accuracy") {
            $this->accuracy += $value;
        }

        if ($type === "strength") {
            $this->weaponStrength += $value;
        }

        if ($type === "strength") {
            $this->weaponStrength += $value;
        }
    }

    public function getTag(): string
    {
        return $this->tag;
    }

}