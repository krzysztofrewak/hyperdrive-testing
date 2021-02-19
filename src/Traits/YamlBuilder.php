<?php

declare(strict_types=1);

namespace Hyperdrive\Traits;

use Symfony\Component\Yaml\Yaml;

trait YamlBuilder
{
    private function buildFromYamlFile(string $path, array &$output): void
    {
        $yamlFile = Yaml::parseFile($path);
        foreach ($yamlFile as $record)
        {
            array_push($output, $record[0] . " - " .  $record[1]);
        }
    }

    private function loadMissionFromYamlFile(string $id): array
    {
        $missionData = [];
        $missionList = array_values(Yaml::parseFile('./src/GameData/missions.yaml'));

        foreach ($missionList as $missionDataArray) {
            $currentMission = array_search($id, $missionDataArray);

            if($currentMission > -1){
                $path = './src/GameData/Missions/' . $missionDataArray[1];
                $missionData = Yaml::parseFile($path);
                break;
            }
        }
        return  $missionData;
    }
}