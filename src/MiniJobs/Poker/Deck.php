<?php

declare(strict_types=1);

namespace Hyperdrive\MiniJobs\Poker;

use ArrayIterator;
use Illuminate\Support\Collection;

class Deck
{
    private Collection $deck;
    private ArrayIterator $cards;

    public function __construct()
    {
        $this->deck = collect();
    }

    public function generateDeck(): void
    {
        $deck = collect();
        $suits = ["spade", "heart", "diamond", "club"];
        for ($i = 2; $i <= 14; $i++) {
            foreach ($suits as $suit) {
                $card = new Card((string)$i, $suit);
                $deck->add($card->getCard());
            }
        }
        $this->deck = $deck;
        $this->deck = $this->deck->shuffle();
        $this->cards = $this->deck->getIterator();
    }

    public function getDeck(): Collection
    {
        return $this->deck;
    }

    public function getCardsFromDeck(int $numberOfCards): Collection
    {
        $cardsToGive = collect();
        for ($i = 0; $i < $numberOfCards; $i++) {
            $card = $this->cards->current();
            $cardsToGive->add($card);
            $this->cards->next();
        }
        return $cardsToGive;
    }
}