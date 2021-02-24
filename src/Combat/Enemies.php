<?php

declare(strict_types=1);

namespace Hyperdrive\Combat;


use Hyperdrive\Output\OutputContract;
use Hyperdrive\Ship\Ship;
use Illuminate\Support\Collection;

class Enemies
{

    private Collection $enemyShips;
    protected OutputContract $output;


    public function __construct(OutputContract $output)
    {
        $this->output = $output;
        $this->enemyShips = collect();
        $this->generateEnemies();
    }

    private function generateEnemies(): void
    {
        $level = rand(1,3);

        switch ($level)
        {
            case 1:
                $this->enemyShips->add(new Ship(output: $this->output,name: "Weakest ship",maxFuel: 0, maxHullIntegrity: 30,maxShields: 50,missileDamage: 20,laserDamage: 15));
                $this->enemyShips->add(new Ship(output: $this->output,name: "Weakest ship",maxFuel: 0, maxHullIntegrity: 30,maxShields: 50,missileDamage: 20,laserDamage: 15));
                $this->enemyShips->add(new Ship(output: $this->output,name: "Weakest ship",maxFuel: 0, maxHullIntegrity: 30,maxShields: 50,missileDamage: 20,laserDamage: 15));
                break;
            case 2:
                $this->enemyShips->add(new Ship(output: $this->output,name: "Weak ship",maxFuel: 0, maxHullIntegrity: 80,maxShields: 70,missileDamage: 40,laserDamage: 30));
                $this->enemyShips->add(new Ship(output: $this->output,name: "Weak ship",maxFuel: 0, maxHullIntegrity: 80,maxShields: 70,missileDamage: 40,laserDamage: 30));
                break;
            case 3:
                $this->enemyShips->add(new Ship(output: $this->output,name: "Medium ship",maxFuel: 0, maxHullIntegrity: 100,maxShields: 80, missileDamage: 50, laserDamage: 40));
                break;
            default:
                break;
        }
    }

    /**
     * @return Collection
     */
    public function getEnemyShips(): Collection
    {
        return $this->enemyShips;
    }


}