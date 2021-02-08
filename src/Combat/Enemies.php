<?php

declare(strict_types=1);

namespace Hyperdrive\Combat;


use Hyperdrive\Ship\Ship;
use Illuminate\Support\Collection;

class Enemies
{

    private Collection $enemyShips;

    /**
     * Enemies constructor.
     */
    public function __construct()
    {
        $this->enemyShips = collect();
        $this->generateEnemies();
    }


    private function generateEnemies(): void
    {
        $level = rand(1,3);

        switch ($level)
        {
            case 1:
                $this->enemyShips->add(new Ship("Weakest ship",0,0,30,30,50,50,20,15));
                $this->enemyShips->add(new Ship("Weakest ship",0,0,30,30,50,50,20,15));
                $this->enemyShips->add(new Ship("Weakest ship",0,0,30,30,50,50,20,15));
                break;
            case 2:
                $this->enemyShips->add(new Ship("Weak ship",0,0,80,80,70,70,40,30));
                $this->enemyShips->add(new Ship("Weak ship",0,0,80,80,70,70,40,30));
                break;
            case 3:
                $this->enemyShips->add(new Ship("Medium Ship",0,0,100,50,80,80,50,40));
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