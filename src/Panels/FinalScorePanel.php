<?php

declare(strict_types=1);

namespace Hyperdrive\Panels;

use Hyperdrive\Player\Player;
use Hyperdrive\Resources\FinalScoreResource;

class FinalScorePanel extends BasePanel
{
    public function __construct(protected Player $player)
    {
        parent::__construct();
    }

    public function show(): void
    {
        $collection = collect();
        $finalScoreResource = new FinalScoreResource();
        $finalScore = $this->player->getFinalScore();

        foreach ($finalScore->getFinalScore() as $name => $value) {
            $collection->add($finalScoreResource($name, $value));
        }

        $this->cli->table($collection->toArray());
    }
}
