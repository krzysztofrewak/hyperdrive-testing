<?php

declare(strict_types=1);

namespace Hyperdrive\MiniJobs\Poker\Helpers;

use Illuminate\Support\Collection;

trait PokerRankingsCalculator
{
    private Collection $cards;

    public function setCards(Collection $cards): void
    {
        $this->cards = $cards;
    }

    public function calculateScore(): int
    {
        $pairs = $this->getRank();
        $pairValue = $pairs->keys();
        $pairsCount = $pairs->values();
        $pairsSum = array_sum($pairsCount->toArray());
        $sequence = $this->getSequence();
        $suit = $this->getSuit();
        if ($suit === 5) {
            if ($sequence === 5) {
                if ($this->checkIfRoyal()) {
                    // A, K, Q, J, 10, all the same suit.
                    return 400;
                } else {
                    // Five cards in a sequence, all in the same suit. 356 - 363
                    return $pairValue[0] + 350;
                }
            } else {
                // Any five cards of the same suit, but not in a sequence. 210 - 265
                return $pairValue[0] * $pairsSum + 200;
            }
        }

        // All four cards of the same rank. 298 - 342
        if ($pairsSum === 4) {
            return $pairValue[0] * $pairsSum + 290;
        }

        // Three of a kind with a pair. 275 - 339
        if ($pairsSum === 5) {
            return ($pairValue[0] * $pairsSum + $pairValue[1] * $pairsSum) + 250;
        }

        // Five cards in a sequence, but not of the same suit. 130 - 185
        if ($sequence === 5) {
            return $pairValue[0] * $sequence + 120;
        }
        // Three cards of the same rank. 86 - 119
        if ($pairsSum === 3) {
            return $pairValue[0] * $pairsSum + 80;
        }
        // Two different pairs. 38 - 82
        if ($pairsSum === 4) {
            return $pairValue[0] * $pairsSum + 30;
        }
        // Two cards of the same rank. 19 - 31
        if ($pairsSum === 2) {
            return $pairsSum * $pairValue[0] + 15;
        }
        // High card. 2 - 13
        return 1 * $pairValue[0];
    }

    private function getSequence(): int
    {
        $values = [];
        $sortedCards = $this->cards->sort()->reverse();
        foreach ($sortedCards as $card) {
            array_push($values, $card[0]);
        }

        $points = 1;
        $highestSequence = 1;
        for ($i = 0; $i <= 3; $i++) {
            if ($values[$i] - $values[$i + 1] === 1) {
                $points++;
            }
            if ($points > $highestSequence) {
                $highestSequence = $points;
            } else {
                $points = 1;
            }
        }
        return $highestSequence;
    }


    private function getSuit(): int
    {
        $values = $this->getCardsType(1);
        $suitArray = array_count_values($values);

        return max($suitArray);
    }

    private function checkIfRoyal(): bool
    {
        $values = $this->getCardsType(0);
        return array_search(13, $values) ? true : false;
    }

    private function getRank(): Collection
    {
        $values = $this->getCardsType(0);
        $highestPair = 1;
        $highestCard = 0;
        $highestArray = collect();
        $suitArray = array_count_values($values);
        krsort($suitArray);
        $maxPair = max($suitArray);

        if ($maxPair > 1) {
            foreach ($suitArray as $card => $pair) {
                if ($pair > $highestPair) {
                    $highestPair = $pair;
                    $highestCard = $card;
                }
                if ($pair > 1) {
                    $highestArray->put($card, $pair);
                }
            }
            $this->typewriterEffect("Highest card value: $highestCard happened $highestPair times");
        } else {
            $card = collect($suitArray)->take(1)->search(1);
            $highestArray->put($card, 1);
            $this->typewriterEffect("Highest card: $card");
        }

        return $highestArray;
    }

    private function getCardsType(int $type): array
    {
        $cards = $this->cards;
        $typeArray = [];
        foreach ($cards as $card) {
            array_push($typeArray, ($card[$type]));
        }
        return $typeArray;
    }
}