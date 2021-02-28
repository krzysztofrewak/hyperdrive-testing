<?php

declare(strict_types=1);

namespace Hyperdrive\Pilot;

use Hyperdrive\Output\OutputContract;
use JetBrains\PhpStorm\Pure;


class Pilot
{
    private string $name;
    private int $reputation;
    private int $skill;
    private int $credits;
    private int $exp;
    protected OutputContract $output;

    public function __construct(OutputContract $output, string $name, int $reputation, int $skill, int $credits, int $exp)
    {
        $this->output = $output;
        $this->name = $name;
        $this->reputation = $reputation;
        $this->skill = $skill;
        $this->credits = $credits;
        $this->exp = $exp;
    }

    public function showStats()
    {
        $this->output->write("");
        $this->output->info("Your character:");
        $this->output->write("Name: " . $this->getName());
        $this->output->write("Reputation: " . $this->getReputation());
        $this->output->write("Skill: " . $this->getSkill());
        $this->output->write("Credits: " . $this->getCredits());
        $this->output->write("EXP: " . $this->getExp());
        $this->output->write("");

    }

    public function checkForLevelUp(): void
    {

        while ($this->getExp() >= 5000) {
            $this->output->write("");
            $this->setExp($this->getExp() - 5000);
            $this->setSkill($this->getSkill() + 1);
            $this->output->info("You leveled up!");
            $this->output->info("Your piloting skills have increased!");
            $this->output->write("Your current skill: " . $this->getSkill());
            $rand = rand(1, 3);
            if ($rand == 3) {
                $this->setReputation($this->getReputation() + 1);
                $this->output->info("Your reputation throughout the galaxy has increased!");
                $this->output->write("Your current reputation: " . $this->getReputation());
            }
        }
    }

    public function choosePilot(Pilot $player, Pilot $choice): void
    {
        $player->setName($choice->getName());
        $player->setReputation($choice->getReputation());
        $player->setSkill($choice->getSkill());
        $player->setCredits($choice->getCredits());

        $this->showStats();
    }

    public function showCredits(): void
    {
        $this->output->write("You have " . $this->getCredits() . " credits.");
    }

    public function earnCredits($payment): void
    {
        $this->setCredits($this->getCredits() + $payment);
    }

    public function earnXP(int $exp): void
    {
        $this->setExp($this->getExp() + $exp);
    }

    public function payCredits($payment): void
    {
        $this->setCredits($this->getCredits() - $payment);
        if ($this->getCredits() < 0) {
            $this->setCredits(0);
        }
    }

    #[Pure] public function calculateBounty(): int
    {
        return ($this->getSkill() + $this->getReputation()) * 100;
    }

    #[Pure] public function calculateToll(): int
    {
        return ($this->getSkill() + $this->getReputation()) * 10;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getReputation(): int
    {
        return $this->reputation;
    }

    public function setReputation(int $reputation): void
    {
        $this->reputation = $reputation;
    }

    public function getSkill(): int
    {
        return $this->skill;
    }

    public function setSkill(int $skill): void
    {
        $this->skill = $skill;
    }

    public function getCredits(): int
    {
        return $this->credits;
    }

    public function setCredits(int $credits): void
    {
        $this->credits = $credits;
    }

    public function getExp(): int
    {
        return $this->exp;
    }

    public function setExp(int $exp): void
    {
        $this->exp = $exp;
    }
}
