<?php

namespace Hyperdrive;

use Hyperdrive\Entity\Players\Capitan;
use Hyperdrive\Entity\Players\Pantheon;
use Hyperdrive\Entity\Players\Samurai;
use League\CLImate\CLImate;

class Game {
    private CLImate $cli;
    private $player;

    public function __construct()
    {
        $this->cli = new CLImate();
    }

    public function startGame() {
        $this->selectLevelOfDifficulty();
    }

    private function selectLevelOfDifficulty(){
        $options = ["easy" => "Easy","medium" => "Medium","hard" => "Hard"];
        $result = $this->cli->radio("Select level of difficulty", $options)->prompt();

        if ($result === "easy") {
            $this->player = $this->selectPlayer(rand(10,23),rand(10,15));
        } else if ($result === "medium") {
            $this->player = $this->selectPlayer(rand(5,10),rand(5,10));
        } else if ($result === "hard") {
            $this->player = $this->selectPlayer(rand(2,5),rand(0,5));
        }
    }

    private function selectPlayer(int $power, int $armor){
        $options = ["capitan" => "Capitan","pantheon" => "Pantheon","samurai" => "Samurai"];
        $result = $this->cli->radio("Select Player", $options)->prompt();
        $player = null;
        if ($result === "capitan") {
            $player = new Capitan($power,$armor,"Capitan",0);
        } else if ($result === "pantheon") {
            $player = new Pantheon($power,$armor,"Pantheon",0);
        } else if ($result === "samurai") {
            $player = new Samurai($power,$armor,"Samurai",0);
        }

        return $player;
    }

    public function getPlayer()
    {
        return $this->player;
    }
}