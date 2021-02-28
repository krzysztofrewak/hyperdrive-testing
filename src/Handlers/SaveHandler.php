<?php

declare(strict_types=1);

namespace Hyperdrive\Handlers;

trait SaveHandler
{
    public function serialize(array $data): void
    {
        $saveFile = fopen($_SESSION['saveFile'], 'w');

        foreach ($data as $record) {
            if (is_array($record)) {
                foreach ($record as $index) {
                    fwrite($saveFile, "$index;");
                }
                fwrite($saveFile, "\n");
            } else {
                fwrite($saveFile, "$record;\n");
            }
        }

        fclose($saveFile);
    }

    public function sortForGameSave(array $data): array
    {
        return [
            "player" => $data["player"],
            "friend1" => $data["friend1"],
            "friend2" => $data["friend2"],
            "money" => $data["money"],
            "fuel" => $data["fuel"],
            "team" => $data["team"],
            "timeSpent" => $data["timeSpent"],
            "currentPlanet" => $data["currentPlanet"],
            "targetPlanet" => $data["targetPlanet"],
            "missionId" => $data["missionId"],
            "stage" => $data["stage"]
        ];
    }
}