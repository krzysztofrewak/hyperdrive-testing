<?php

declare(strict_types=1);

namespace Hyperdrive\MiniJobs\Poker;

use Hyperdrive\MiniJobs\BaseMiniJob;
use Hyperdrive\MiniJobs\Poker\Helpers\CardHandler;
use Hyperdrive\MiniJobs\Poker\Helpers\PokerRankingsCalculator;
use Hyperdrive\Handlers\TextHandler;
use Illuminate\Support\Collection;

class Poker extends BaseMiniJob
{
    use TextHandler;
    use PokerRankingsCalculator;
    use CardHandler;

    private Deck $deck;
    private Collection $winners;
    private int $moneyPool;
    private int $stake = 2000;

    protected function prepareEnvironment(): void
    {
        $this->deck = new Deck();
    }

    protected function setupActors(): void
    {
        $this->players = collect();
        $this->players->add(new PokerPlayerHuman($this->playerName, $this->playerMoney));
        for ($i = 1; $i <= 3; $i++) {
            $this->players->add(new PokerPlayer((string)$i));
        }
    }

    protected function play(): void
    {
        if ($this->doesPlayerWantToPlay()) {
            if ($this->areEnoughPlayers()) {
                $this->deck->generateDeck();
                $this->executeMainLoop();
                $this->calculateOutcome();
                $this->payout();
                $this->increaseStake();
                $this->play();
            }
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

    private function areEnoughPlayers(): bool
    {
        $suitablePlayers = collect();
        foreach ($this->players as $player) {
            if ($player->hasMoney($this->stake)) {
                $suitablePlayers->add($player);
            }
        }

        if (sizeof($suitablePlayers) > 1) {
            $this->players = $suitablePlayers;
            return true;
        } else {
            $this->typewriterEffect("There aren't enough players");
            return false;
        }
    }

    private function executeMainLoop(): void
    {
        $this->moneyPool = 0;
        $this->placeBets();
        foreach ($this->players as $player) {
            $player->addCards($this->deck->getCardsFromDeck(5));
            $this->exchangeCards($player);
        }
    }

    private function placeBets(): void
    {
        foreach ($this->players as $player) {
            $this->moneyPool += $player->bet($this->stake);
        }
    }


    private function exchangeCards(PokerPlayer $player): void
    {
        $ids = $player->selectCardsToRemove();
        $removedCount = sizeof($ids);
        $player->removeCardsById($ids);
        $player->giveCards($this->deck->getCardsFromDeck($removedCount));
    }

    private function calculateOutcome(): void
    {
        $winningPlayers = collect();
        $highestScore = 0;
        $players = $this->players;
        $this->typewriterEffect("Money in pot $this->moneyPool");
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
        $this->winners = $winningPlayers;
    }

    private function payout(): void
    {
        $winnersNumber = sizeof($this->winners);
        $payout = (int)(($this->moneyPool) / $winnersNumber);
        if ($winnersNumber === 1) {
            $player = $this->players->where("name", $this->winners->first())->first();
            $this->typewriterEffect("Player $player->name won $payout credits");
            $player->payOut($payout);
        } else {
            foreach ($this->winners as $player) {
                $player = $this->players->where("name", $player)->first();
                $this->typewriterEffect("$player->name won $payout credits");
                $player->payOut($payout);
            }
        }
    }

    private function getScore(Collection $cards): int
    {
        $this->setCards($cards);
        return $this->calculateScore();
    }

    private function increaseStake(): void
    {
        $this->stake += 1000;
    }
}
