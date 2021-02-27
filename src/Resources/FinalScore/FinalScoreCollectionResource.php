<?php

declare(strict_types=1);

namespace Hyperdrive\Resources\FinalScore;

class FinalScoreCollectionResource
{
    public function __invoke(array $array): array
    {
        $data = [];
        $finalScoreResource = new FinalScoreResource();

        foreach ($array as $name => $value) {
            $data[] = $finalScoreResource($name, $value);
        }

        return $data;
    }
}
