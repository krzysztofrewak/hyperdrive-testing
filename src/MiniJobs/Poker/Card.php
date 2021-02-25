<?php


namespace Hyperdrive\MiniJobs\Poker;


class Card
{
    private string $type;
    private string $suit;

    public function __construct(string $type, string $suit)
    {
        $this->type = $type;
        $this->suit = $suit;
    }

    public function getCard(): array
    {
        return [$this->type, $this->suit];
    }
}