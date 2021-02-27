<?php


namespace Hyperdrive\MiniJobs\Poker\Helpers;


use Illuminate\Support\Collection;

trait CardHandler
{
    public function translateCard(array $card): array
    {
        $value = $card[0];
        $suit = $card[1];

        if ($value === "14" || $value === "A") {
            $value = $value === "14" ? "A" : "14";
        }

        if ($value === "13" || $value === "K") {
            $value = $value === "13" ? "K" : "13";
        }

        if ($value === "12" || $value === "Q") {
            $value = $value === "12" ? "Q" : "12";
        }

        if ($value === "11" || $value === "J") {
            $value = $value === "11" ? "J" : "11";
        }

        return [$value, $suit];
    }

    public function displayCards(Collection $cards): void
    {
        foreach ($cards as $hand => $card) {
            $card = $this->translateCard($card);
            $this->typewriterEffect("$card[0] $card[1]");
        }
    }
}