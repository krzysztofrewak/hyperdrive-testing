<?php


namespace Hyperdrive\Entity;

use Hyperdrive\Quests\DefeatEnemy;
use Hyperdrive\Quests\SpendTokens;
use Hyperdrive\Quests\UseWeapon;
use Hyperdrive\Quests\VisitPlanets;

class Quest {

     private DefeatEnemy $defeatEnemy;
     private SpendTokens $spendTokens;
     private UseWeapon $useWeapon;
     private VisitPlanets $visitPlanets;

    public function __construct(DefeatEnemy $defeatEnemy, SpendTokens $spendTokens, UseWeapon $useWeapon, VisitPlanets $visitPlanets)
    {
        $this->defeatEnemy = $defeatEnemy;
        $this->spendTokens = $spendTokens;
        $this->useWeapon = $useWeapon;
        $this->visitPlanets = $visitPlanets;
    }


    public function getDefeatEnemy(): DefeatEnemy
    {
        return $this->defeatEnemy;
    }

    public function getSpendTokens(): SpendTokens
    {
        return $this->spendTokens;
    }

    public function getUseWeapon(): UseWeapon
    {
        return $this->useWeapon;
    }

    public function getVisitPlanets(): VisitPlanets
    {
        return $this->visitPlanets;
    }


}