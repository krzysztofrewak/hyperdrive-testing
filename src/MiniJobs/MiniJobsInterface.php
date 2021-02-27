<?php


namespace Hyperdrive\MiniJobs;


interface MiniJobsInterface
{
    public function __construct(string $playerName, int $money);

    public function getPlayerEarnings(): int;
}