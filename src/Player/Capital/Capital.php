<?php

declare(strict_types=1);

namespace Hyperdrive\Player\Capital;

use Symfony\Component\Config\Definition\Exception\Exception;

class Capital
{
    public function __construct(protected int $capital)
    {
    }

    public function getCapital(): int
    {
        return $this->capital;
    }

    public function spendingMoney(int $charge): void
    {
        $this->isThereEnoughMoney($charge);
        $this->capital -= $charge;
    }

    /**
     * @throws Exception
     */
    public function isThereEnoughMoney(int $charge): void
    {
        if ($this->capital - $charge < 0) {
            throw new Exception("You don't have enough money");
        }
    }
}
