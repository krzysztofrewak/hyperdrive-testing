<?php

declare(strict_types=1);

namespace Hyperdrive\Modules\Combat;

use Hyperdrive\Handlers\TextHandler;

class Being implements CombatInterface
{
    use TextHandler;

    public string $name;
    protected int $health = 100;
    protected int $weaponType;
    protected int $weaponStrength = 10;
    protected int $accuracy = 70;
    protected int $defence = 3;
    protected string $tag;
    protected ?string $specialization;
    protected ?int $bonus = null;

    public function __construct(string $name, int $coverBonus)
    {
        $this->name = $name;
        $this->defence += $coverBonus;
    }

    public function shoot(Being $enemy): void
    {
        $accuracy = $this->accuracy + rand(5, 25);
        $this->typewriterEffect("$this->name shoots with $accuracy% accuracy.");
        $enemy->beShotAt($accuracy, $this->weaponStrength);
    }

    private function beShotAt(int $accuracy, int $damageToReceive): void
    {
        $doesShotLand = rand(1, 100) <= $accuracy;

        if ($doesShotLand) {
            $this->typewriterEffect("$this->name is shot!");
            $this->updateHealth($damageToReceive - $this->defence);
        } else {
            $this->typewriterEffect("Miss!");
        }
    }

    private function updateHealth(int $value): void
    {
        $this->health -= abs($value);
        $this->typewriterEffect("$this->name has now $this->health health points.");
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
        return $this->weaponType * 10;
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
            echo "Applying bonus $type with value $value" . PHP_EOL;
            $this->defence += $value;
        }

        if ($type === "accuracy") {
            echo "Applying bonus $type with value $value" . PHP_EOL;
            $this->accuracy += $value;
        }

        if ($type === "strength") {
            echo "Applying bonus $type with value $value" . PHP_EOL;
            $this->weaponStrength += $value;
        }

        if ($type === "strength") {
            echo "Applying bonus $type with value $value" . PHP_EOL;
            $this->weaponStrength += $value;
        }
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function isAlive(): bool
    {
        return $this->health > 0;
    }

    public function getDisplayInfo(): array
    {
        return [$this->name, $this->weaponStrength, $this->defence];
    }

}