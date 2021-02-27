<?php

declare(strict_types=1);

namespace Hyperdrive\Resources\Level;

use Hyperdrive\Level\Level;
use Illuminate\Support\Collection;

class LevelCollectionResource
{
    public function __invoke(Collection $collection): array
    {
        $data = [];
        $levelResource = new LevelResource();

        /** @var Level $level */
        foreach ($collection as $level) {
            $data[] = $levelResource($level);
        }

        return $data;
    }
}
