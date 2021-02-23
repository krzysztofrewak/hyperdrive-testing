<?php


namespace Hyperdrive\Interfaces;


interface PlayerInterface
{
    public function supperAttack(?int $enemyHp):int;
    function levelUpgrade(): void;
}