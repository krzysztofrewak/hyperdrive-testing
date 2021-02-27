<?php

declare(strict_types=1);

namespace Hyperdrive\Game\NewGame;

use Hyperdrive\BaseGameType;
use League\CLImate\CLImate;
use Hyperdrive\GameSave;
use Hyperdrive\Traits\YamlBuilder;

class NewGame extends BaseGameType
{
    use YamlBuilder;

    private array $gameData = [];
    private array $specializations = [];
    private array $teams = [];
    private CLImate $cli;

    public function __construct()
    {
        $this->cli = new CLImate();
        $this->gameSave = new GameSave();
        $this->parseYamlFiles();
        $this->getUserControlledUnitsInfo();
        $this->gameSave->fillNewSave($this->gameData);
    }

    private function parseYamlFiles(): void
    {
        $this->buildFromYamlFile('/application/src/GameData/teams.yaml', $this->teams);
        $this->buildFromYamlFile('/application/src/GameData/specializations.yaml', $this->specializations);
    }

    private function getUserControlledUnitsInfo()
    {
        $this->getMainHeroInfo();
        $this->getFriendsInfo();
        unset($this->cli);
    }

    private function getMainHeroInfo(): void
    {
        $name = $this->cli->input("What is your name: ")->prompt();
        $options = $this->getSpecializations();
        $spec = $this->cli->radio("Select your specialization: ", $options)->prompt();
        $options = $this->getTeams();
        $origin = $this->cli->radio("Select your home land: ", $options)->prompt();
        array_push($this->gameData, [$name, $spec, $origin]);
    }

    private function getFriendsInfo(): void
    {
        $this->getFriendInfo();
        $this->getFriendInfo();
    }

    private function getFriendInfo(): void
    {
        $name = $this->cli->input("What is your friend's name: ")->prompt();
        $options = $this->getSpecializations();
        $options = array_slice($options, 1);
        $spec = $this->cli->radio("Select your friend's specialization: ", $options)->prompt();
        array_push($this->gameData, [$name, $spec]);
    }

    private function getSpecializations(): array
    {
        return $this->specializations;
    }

    private function getTeams(): array
    {
        return $this->teams;
    }
}