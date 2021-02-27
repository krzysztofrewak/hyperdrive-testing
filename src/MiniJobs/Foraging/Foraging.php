<?php

declare(strict_types=1);

namespace Hyperdrive\MiniJobs\Foraging;

use Hyperdrive\MiniJobs\BaseMiniJob;
use Hyperdrive\Traits\TextHandler;

class Foraging extends BaseMiniJob
{
    use TextHandler;

    private Forest $forest;
    private int $earnedMoney = 0;

    protected function prepareEnvironment(): void
    {
        $this->forest = new Forest();
    }

    protected function setupActors(): void
    {
        $this->forest->populate();
    }

    protected function play(): void
    {
        $foundFood = $this->forest->find("berries");
        $this->sell($foundFood);
    }

    private function sell(int $foodAmount): void
    {
        $this->loadingEffect("Selling $foodAmount jars at the highway", 1);
        for ($i = 0; $i < $foodAmount; $i++) {
            $chanceToSell = rand(30, 100);
            if ($chanceToSell >= 70) {
                $this->earnedMoney += 1000;
            }
        }
        $this->typewriterEffect("You have managed to earn $this->earnedMoney");
    }

    public function getPlayerEarnings(): int
    {
        return $this->earnedMoney;
    }
}