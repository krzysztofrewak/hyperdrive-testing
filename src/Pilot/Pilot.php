<?php

declare(strict_types=1);

namespace Hyperdrive\Pilot;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;


class Pilot
{
    protected ?string $name = null;
    protected ?int $reputation = 0;
    protected ?int $skill = 0;

    /**
     * Pilot constructor.
     * @param string $name
     * @param int $reputation
     * @param int $skill
     */
    public function __construct(string $name, int $reputation, int $skill)
    {
        $this->name = $name;
        $this->reputation = $reputation;
        $this->skill = $skill;
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
     * @return Collection
     */
    public function getPilots(): Collection
    {
        return $this->pilots;
    }

    /**
     * @param Collection $pilots
     */
    public function setPilots(Collection $pilots): void
    {
        $this->pilots = $pilots;
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
