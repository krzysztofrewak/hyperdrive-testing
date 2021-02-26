<?php

declare(strict_types=1);

namespace Hyperdrive\Player\Capital;

use Symfony\Component\Config\Definition\Exception\Exception;

class Capital
{
    protected int $capitalSpent = 0;

    public function __construct(protected int $capital)
    {
    }

    public function getCapitalSpent(): int
    {
        return $this->capitalSpent;
    }

    public function getCurrentCapital(): int
    {
        return $this->capital - $this->capitalSpent;
    }

    public function spendingMoney(int $charge): void
    {
        $this->isThereEnoughMoney($charge);
        $this->capitalSpent += $charge;
    }

    /**
     * @throws Exception
     */
    public function isThereEnoughMoney(int $charge): void
    {
        if ($this->getCurrentCapital() - $charge < 0) {
            throw new Exception("You don't have enough money");
        }
    }
}
