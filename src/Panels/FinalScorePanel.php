<?php

declare(strict_types=1);

namespace Hyperdrive\Panels;

use Hyperdrive\Player\Player;
use Hyperdrive\Resources\FinalScore\FinalScoreCollectionResource;

class FinalScorePanel extends BasePanel
{
    public function __construct(protected Player $player)
    {
        parent::__construct();
    }

    public function show(): void
    {
        $finalScore = $this->player->generateFinalScore();
        $finalScoreCollectionResource = new FinalScoreCollectionResource();

        $this->cli->table($finalScoreCollectionResource($finalScore->generate()));
    }
}
