<?php

declare(strict_types=1);

namespace Hyperdrive\Game\NewGame;

use Hyperdrive\GameSave;
use Hyperdrive\Traits\YamlBuilder;
use League\CLImate\CLImate;

class NewGame
{
    use YamlBuilder;

    private array $gameData = [];
    private array $specializations = [];
    private array $teams = [];
    private GameSave $gameSave;
    private CLImate $cli;

    public function __construct()
    {
        $this->cli = new CLImate();
        $this->gameSave = new GameSave();
        $this->parseYamlFiles();
        $this->getUserControlledUnitsInfo();
        $this->gameSave->fillNewSave($this->gameData);
        unset($this->cli);
    }

    private function parseYamlFiles(): void
    {
        // consider loop when gamedata folder is structured
        $this->buildFromYamlFile('/application/src/GameData/teams.yaml', $this->teams);
        $this->buildFromYamlFile('/application/src/GameData/specializations.yaml', $this->specializations);
    }

    private function getUserControlledUnitsInfo()
    {
        $this->getMainHeroInfo();
        $this->getFriendsInfo();
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

    public function getGameSave(): GameSave
    {
        return $this->gameSave;
    }
}