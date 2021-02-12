<?php

declare(strict_types=1);

namespace Hyperdrive\Entity;

use Hyperdrive\Geography\Planet;

class Person
{
    protected int $token;
    protected array $logs = [];
    protected int $cash;

    public function __construct()
    {
        $this->token = rand(20,30);
        $this->cash = rand(30,45);
    }

    public function __toString(): string
    {
        return "Price: ".$this->token;
    }

    public function getToken(): int
    {
        return $this->token;
    }

    public function setToken(int $count): void
    {
        if ($count < 0) echo "Subtracted ".$count." tokens. \n";
        else echo "Added ".$count." tokens. \n";

        $this->token += $count;
    }

    public function getLogs()
    {
        echo "You visited:\n ";
        array_map(function ($planet) {
            echo $planet." -> ";
        }, $this->logs);
    }


    public function setLogs(Planet $planet): void
    {
        array_push($this->logs,$planet->getName());
    }

    public function getCash(): int
    {
        return $this->cash;
    }

    public function setCash(int $cash): void
    {
        $this->cash += $cash;
    }



}
