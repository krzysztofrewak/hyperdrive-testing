<?php

declare(strict_types=1);

namespace Hyperdrive\MiniJobs\Poker;

use Hyperdrive\Traits\TextHandler;
use Illuminate\Support\Collection;

class Poker
{
    use TextHandler;

    private Deck $deck;
    private PokerPlayer $p1;
    private PokerPlayer $p2;
    private PokerPlayer $p3;
    private PokerPlayer $p4;
    private Collection $players;
    private int $moneyPool;
    protected int $stake = 2000;

    public function __construct()
    {
        $this->deck = new Deck();
        $this->p1 = new PokerPlayerHuman();
        $this->p2 = new PokerPlayer();
        $this->p3 = new PokerPlayer();
        $this->p4 = new PokerPlayer();
        $this->players = collect();
        $this->players->add($this->p1)->add($this->p2)->add($this->p3)->add($this->p4);
        $this->play();
    }

    public function play(): void
    {
        if ($this->doesPlayerWantToPlay()) {
            $this->moneyPool = 0;
            $this->deck->generateDeck();
            $this->placeBets();
            $this->p1->addCards($this->deck->getCardsFromDeck(5));
            $this->p2->addCards($this->deck->getCardsFromDeck(5));
            $this->p3->addCards($this->deck->getCardsFromDeck(5));
            $this->p4->addCards($this->deck->getCardsFromDeck(5));
            $this->exchangeCards();
            $this->outcome();
            //$this->increaseStake();
            $this->play();
        }
    }

    private function doesPlayerWantToPlay(): bool
    {
        $options = ["1" => "Yes", "" => "No"];
        $this->typewriterEffect("Current bet amount is $this->stake.");
        $decision = (bool)$this->getInput($options, "Do you wish to proceed?");

        if ($decision) {
            if ($this->p1->hasMoney($this->stake)) {
                return true;
            }
            $this->typewriterEffect("You don't have enough money to cover the bet.");
        }
        return false;
    }

    public function getPlayerEarnings(): int
    {
        return $this->p1->getPlayerMoney();
    }

    private function placeBets(): void
    {
        $players = $this->players;
        foreach ($players as $player) {
            if ($player->hasMoney($this->stake)) {
                $this->moneyPool += $player->bet();
            } else {
                $id = $this->players->search($player);
                $this->typewriterEffect("Player $id was kicked out.");
                $this->players->forget($id);
            }
        }
    }

    private function exchangeCards(): void
    {
        $players = $this->players;
        foreach ($players as $player) {
            $ids = $player->selectCardsToRemove();
            $removedCount = sizeof($ids);
            $player->removeCardsById($ids);
            $player->giveCards($this->deck->getCardsFromDeck($removedCount));
        }
    }

    private function outcome(): void
    {
        $winningPlayer = [];
        $players = $this->players;
        foreach ($players as $player) {
            $playerCards = $player->getCards();
            $score = $this->calculateScore($playerCards);
            if ($score > $winningPlayer[1]) {
                $winningPlayer = [$player, $score];
            }
            // remake
            if ($score === $winningPlayer[1]) {
                $player->givePrize($this->moneyPool / 2);
                $winningPlayer[0]->givePrize($this->moneyPool / 2);
                break;
            }
        }
    }

    protected function calculateScore(): int
    {

    }
}