<?php

declare(strict_types=1);

namespace Hyperdrive\Pilot;

use Hyperdrive\Output\OutputContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use League\CLImate\CLImate;
use phpDocumentor\Reflection\Types\This;


class Pilot
{
    private string $name;
    private int $reputation;
    private int $skill;
    private int $credits;
    private int $exp;
    protected OutputContract $output;

    /**
     * Pilot constructor.
     * @param string $name
     * @param int $reputation
     * @param int $skill
     * @param int $credits
     * @param int $exp
     * @param OutputContract $output
     */
    public function __construct(string $name, int $reputation, int $skill, int $credits, int $exp, OutputContract $output)
    {
        $this->name = $name;
        $this->reputation = $reputation;
        $this->skill = $skill;
        $this->credits = $credits;
        $this->exp = $exp;
        $this->output = $output;
    }

    public function showStats()
    {
        $this->output->info("Your character:");
        $this->output->write("Name: ".$this->getName());
        $this->output->write("Reputation: ".$this->getReputation());
        $this->output->write("Skill: ".$this->getSkill());
    }
    public function checkForLevelUp(): void
    {

        while($this->getExp() >= 5000)
        {

            $this->setExp($this->getExp()-5000);
            $this->setSkill($this->getSkill()+1);
            $this->output->info("You leveled up!");
            $this->output->info("Your piloting skills have increased!");
            $this->output->write("Your current skill: ".$this->getSkill());
            $rand = rand(1,3);
            if($rand==3)
            {
                $this->setReputation($this->getReputation()+1);
                $this->output->info("Your reputation throughout the galaxy has increased!");
                $this->output->write("Your current reputation: ".$this->getReputation());
            }
        }
    }

    public function choosePilot(Pilot $player, Pilot $choice): void
    {
        $player->setName($choice->getName());
        $player->setReputation($choice->getReputation());
        $player->setSkill($choice->getSkill());
        $player->setCredits($choice->getCredits());
    }

    public function earnCredits(Int $payment): void
    {
        $this->setCredits($this->getCredits() + $payment);
    }

    public function earnXP(Int $exp): void
    {
        $this->setExp($this->getExp() + $exp);
    }

    public function payCredits(Int $payment): void
    {
        $this->setCredits($this->getCredits() - $payment);
        if($this->getCredits()<0)
        {
            $this->setCredits(0);
        }
    }

    public function calculateBounty(): int
    {
        return ($this->getSkill()+$this->getReputation()) * 100;
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getReputation(): int
    {
        return $this->reputation;
    }

    /**
     * @param int $reputation
     */
    public function setReputation(int $reputation): void
    {
        $this->reputation = $reputation;
    }

    /**
     * @return int
     */
    public function getSkill(): int
    {
        return $this->skill;
    }

    /**
     * @param int $skill
     */
    public function setSkill(int $skill): void
    {
        $this->skill = $skill;
    }

    /**
     * @return int
     */
    public function getCredits(): int
    {
        return $this->credits;
    }

    /**
     * @param int $credits
     */
    public function setCredits(int $credits): void
    {
        $this->credits = $credits;
    }

    /**
     * @return int
     */
    public function getExp(): int
    {
        return $this->exp;
    }

    /**
     * @param int $exp
     */
    public function setExp(int $exp): void
    {
        $this->exp = $exp;
    }





}
