<?php

namespace Hyperdrive\Quests;

use Hyperdrive\Payment\Currency\Currency;

abstract class Quest
{
    public function __construct(protected Currency $reward)
    {}

    public function getReward(): Currency
    {
        return $this->reward;
    }
}