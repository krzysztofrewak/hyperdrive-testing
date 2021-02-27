<?php

declare(strict_types=1);

namespace Hyperdrive\MiniJobs\Poker;

use Hyperdrive\Traits\TextHandler;
use Illuminate\Support\Collection;

class PokerPlayer
{
    use TextHandler;

    public string $name;
    private int $money;
    protected Collection $cards;
    protected int $suit;

    public function __construct(string $name, int $money = 10000)
    {
        $this->name = $name;
        $this->money = $money;
    }

    public function payOut(int $wonMoney): void
    {
        $this->money += $wonMoney;
    }

    public function addCards(Collection $cards): void
    {
        $this->cards = $cards;
    }

    public function giveCards(Collection $cards): void
    {
        $this->cards = $this->cards->merge($cards);
    }

    public function bet(): int
    {
        $amount = 2000;
        $this->money -= $amount;
        return $amount;
    }

    public function selectCardsToRemove(): array
    {
        $range = rand(0, 4);
        return range(1, $range);
    }

    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function getPlayerMoney(): int
    {
        return $this->money;
    }

    public function hasMoney(int $stake): bool
    {
        return $this->money - $stake >= 0;
    }

    public function removeCardsById(array $cardsToRemove): void
    {
        foreach ($cardsToRemove as $card) {
            $this->cards->forget($card);
        }
    }
}