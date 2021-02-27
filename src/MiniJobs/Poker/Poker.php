<?php

declare(strict_types=1);

namespace Hyperdrive\MiniJobs\Poker;

use Hyperdrive\MiniJobs\Poker\Helpers\CardHandler;
use Hyperdrive\MiniJobs\Poker\Helpers\PokerRankingsCalculator;
use Hyperdrive\Traits\TextHandler;
use Illuminate\Support\Collection;

class Poker
{
    use TextHandler;
    use PokerRankingsCalculator;
    use CardHandler;

    private Deck $deck;
    private PokerPlayer $p1;
    private PokerPlayer $p2;
    private PokerPlayer $p3;
    private PokerPlayer $p4;
    private Collection $players;
    private int $moneyPool;
    protected int $stake = 2000;

    public function __construct(string $playerName, int $money)
    {
        $this->deck = new Deck();
        $this->players = collect();
        $this->players->add(new PokerPlayerHuman($playerName, $money));
        for ($i = 1; $i <= 3; $i++) {
            $this->players->add(new PokerPlayer((string)$i));
        }
        $this->play();
    }

    public function play(): void
    {
        if ($this->doesPlayerWantToPlay()) {
            $this->moneyPool = 0;
            $this->deck->generateDeck();
            $this->placeBets();
            foreach ($this->players as $player) {
                $player->addCards($this->deck->getCardsFromDeck(5));
            }
            $this->exchangeCards();
            $this->outcome();
            $this->increaseStake();
            $this->play();
        }
    }

    private function doesPlayerWantToPlay(): bool
    {
        $options = ["1" => "Yes", "" => "No"];
        $player = $this->players->get(0);
        $money = $player->getPlayerMoney();
        $this->typewriterEffect("You currently have $money.");
        $this->typewriterEffect("Current bet amount is $this->stake.");
        $decision = (bool)$this->getInput($options, "Do you wish to proceed?");

        if ($decision) {
            if ($player->hasMoney($this->stake)) {
                return true;
            }
            $this->typewriterEffect("You don't have enough money to cover the bet.");
        }
        return false;
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
        $winningPlayers = collect();
        $highestScore = 0;
        $players = $this->players;
        foreach ($players as $player) {
            $playerCards = $player->getCards();
            $this->typewriterEffect("Player $player->name has these cards.");
            $this->displayCards($playerCards);
            $currentScore = $this->getScore($playerCards);
            $this->typewriterEffect("$player->name has scored $currentScore points.");
            sleep(2);

            if ($currentScore === $highestScore) {
                $winningPlayers->add($player->name);
            }

            if ($currentScore > $highestScore) {
                $winningPlayers = collect();
                $winningPlayers->add($player->name);
                $this->typewriterEffect("$player->name is currently a winner with score $currentScore.");
                $highestScore = $currentScore;
            }
        }

        $winnersNumber = sizeof($winningPlayers);
        $payout = (int)(($this->moneyPool) / $winnersNumber);
        if ($winnersNumber === 1) {
            $player = $this->players->where("name", $winningPlayers->first())->first();
            $this->typewriterEffect("Player $player->name won $payout credits");
            $player->payOut($payout);
        } else {
            foreach ($winningPlayers as $player) {
                $player = $this->players->where("name", $winningPlayers->first())->first();
                $this->typewriterEffect("$winningPlayers won $payout credits");
                $player->payOut($payout);
            }
        }
    }

    protected function getScore(Collection $cards): int
    {
        $this->setCards($cards);
        return $this->calculateScore();
    }

    public function getPlayerEarnings(): int
    {
        return $this->players->get(0)->getPlayerMoney();
    }

    public function increaseStake(): void
    {
        $this->stake += 1000;
    }
}
