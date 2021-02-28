<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

class Mission
{
    public array $data;
    private array $stage;
    private DecisionHandler $handler;

    public function __construct(array $data, string $missionId)
    {
        $this->data = array_values($data);
        $this->handler = new DecisionHandler($missionId);
        $this->stage = $this->data[0];
    }

    public function getMissionData(): array
    {
        return $this->data;
    }

    public function getDecisionHandler()
    {
        return $this->handler->getUniqueHandler();
    }
}