<?php

declare(strict_types=1);

namespace Hyperdrive\MiniJobs\Poker;

use Illuminate\Support\Collection;

trait PokerRankingsCalculator
{
    private Collection $cards;

    public function setCards(Collection $cards): void
    {
        $this->cards = $cards;
    }

    public function calculateScore()
    {
        $sequence = $this->getSequence();
        $suit = $this->getSuit();
        if ($suit === 5) {
            if($sequence === 5) {
                if ($this->checkIfRoyal()) {
                    return 10;
                } else {
                    return 9;
                }
            } else {
                return 5;
            }
        }
        // do FoaK and FH
        $this->getRank();
        // sequen but not suit
        // do ToaK
        // do 2P
        // Highest card

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
            $v1 = $values[$i];
            $v2 = $values[$i + 1];
            if ($v1 - $v2 === 1) {
                $points++;
            }
            if ($points > $highestSequence) {
                $highestSequence = $points;
            } else {
                $points = 1;
            }
        }
        dump("streak found $highestSequence");
        return $highestSequence;
    }


    private function getSuit(): int
    {
        $cards = $this->cards;
        $values = [];
        foreach ($cards as $card) {
            array_push($values, ($card[1]));
        }
        $suitArray = array_count_values($values);

        return max($suitArray);
    }

    private function checkIfRoyal(): bool
    {
        $cards = $this->cards;
        $values = [];
        foreach ($cards as $card) {
            array_push($values, ($card[0]));
        }
        return array_search(13, $values) ? true : false ;
    }
}