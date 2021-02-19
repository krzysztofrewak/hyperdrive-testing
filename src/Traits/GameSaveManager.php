<?php

declare(strict_types=1);

namespace Hyperdrive\Traits;

trait GameSaveManager
{
/*    private array $player;
    protected array $friend1;
    protected array $friend2;
    protected string $team;
    protected int $money;
    protected int $fuel;
    protected string $currentPlanet;
    protected string $targetPlanet;
    protected string $missionId;
    protected int $stage;*/

    public function saveGame(): void
    {

    }

    public function getGameState(): array
    {
        $data = [];
        array_push(
            $data,
            $this->player,
            $this->friend1,
            $this->friend2,
            $this->team,
            $this->money,
            $this->fuel,
            $this->currentPlanet,
            $this->targetPlanet,
            $this->missionId,
            $this->stage
        );
    }
}