<?php

declare(strict_types=1);

namespace Hyperdrive\Pilot;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use League\CLImate\CLImate;


class Pilot
{
    private string $name;
    private int $reputation;
    private int $skill;
    private int $credits;
    private int $exp;

    /**
     * Pilot constructor.
     * @param string $name
     * @param int $reputation
     * @param int $skill
     * @param int $credits
     * @param int $exp
     */
    public function __construct(string $name, int $reputation, int $skill, int $credits, int $exp)
    {
        $this->name = $name;
        $this->reputation = $reputation;
        $this->skill = $skill;
        $this->credits = $credits;
        $this->exp = $exp;
    }

    public function showStats(CLImate $cli)
    {
        $cli->info("Your character:");
        $cli->out("Name: ".$this->getName());
        $cli->out("Reputation: ".$this->getReputation());
        $cli->out("Skill: ".$this->getSkill());
    }
    public function checkForLevelUp(CLImate $cli): void
    {

        while($this->getExp() >= 5000)
        {

            $this->setExp($this->getExp()-5000);
            $this->setSkill($this->getSkill()+1);
            $cli->info("You leveled up!");
            $cli->info("Your piloting skills have increased!");
            $cli->out("Your current skill: ".$this->getSkill());
            $rand = rand(1,3);
            if($rand==3)
            {
                $this->setReputation($this->getReputation()+1);
                $cli->info("Your reputation throughout the galaxy has increased!");
                $cli->out("Your current reputation: ".$this->getReputation());
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

    public function payCredits(Int $payment): void
    {
        $this->setCredits($this->getCredits() - $payment);
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
