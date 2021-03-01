<?php

namespace Hyperdrive\Player;

use Hyperdrive\Payment\Wallet\Wallet;
use Hyperdrive\Products\Spacecrafts\Spacecraft;
use Hyperdrive\Quests\TransportQuest;

class Player
{
    private ?TransportQuest $currentQuest;

    public function __construct(private Wallet $wallet, private Spacecraft $spaceCraft)
    {
        $this->currentQuest = null;
    }

    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    public function setWallet(Wallet $wallet): void
    {
        $this->wallet = $wallet;
    }

    public function getSpaceCraft(): Spacecraft
    {
        return $this->spaceCraft;
    }

    public function setSpaceCraft(Spacecraft $spaceCraft): void
    {
        $this->spaceCraft = $spaceCraft;
    }

    public function getCurrentQuest(): ?TransportQuest
    {
        return $this->currentQuest;
    }

    public function setCurrentQuest(?TransportQuest $currentQuest): void
    {
        $this->currentQuest = $currentQuest;
    }

    public function deleteCurrentQuest(): void
    {
        $this->currentQuest = null;
    }
}