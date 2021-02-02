<?php

declare(strict_types=1);

namespace Hyperdrive\Pilot;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;


class Pilot
{
    private string $name;
    private int $reputation;
    private int $skill;
    private int $credits;

    /**
     * Pilot constructor.
     * @param string $name
     * @param int $reputation
     * @param int $skill
     * @param int $credits
     */
    public function __construct(string $name, int $reputation, int $skill, int $credits)
    {
        $this->name = $name;
        $this->reputation = $reputation;
        $this->skill = $skill;
        $this->credits = $credits;
    }


    public function choosePilot(Pilot $player, Pilot $choice): void
    {
        $player->setName($choice->getName());
        $player->setReputation($choice->getReputation());
        $player->setSkill($choice->getSkill());
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



}
