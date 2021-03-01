<?php

namespace Hyperdrive\Quests;

use Hyperdrive\Payment\Currency\Currency;

class TransportQuest extends Quest
{
    public function __construct(
        private string $direction,
        private string $commodityType,
        private string $commodityQuantity,
        Currency $reward)
    {
        parent::__construct($reward);
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    public function getCommodityType(): string
    {
        return $this->commodityType;
    }

    public function getCommodityQuantity(): string
    {
        return $this->commodityQuantity;
    }




}