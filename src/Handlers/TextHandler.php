<?php

declare(strict_types=1);

namespace Hyperdrive\Handlers;

use League\CLImate\CLImate;
use Illuminate\Support\Collection;

trait TextHandler
{
    private CLImate $climate;

    public function construct()
    {
        $this->climate = new CLImate();
        $this->climate->addArt('./src/GameData/Art');
    }

    public function typewriterEffect(string $sentence = ""): void
    {
        $this->climate = new CLImate();
        foreach (str_split($sentence) as $letter) {
            $this->climate->inline($letter);
            usleep(5000);
        }
        //sleep(1);
        echo PHP_EOL;
    }

    public function drawBanner(string $id): void
    {
        $this->climate = new CLImate();
        $this->climate->addArt('./src/GameData/Art');
        $this->climate->animation($id)->speed('70')->enterFrom('bottom');
        //sleep(6);
    }

    public function loadingEffect(string $sentence, int $length = 3): void
    {
        $this->climate = new CLImate();
        $this->climate->inline($sentence);
        for ($i = 0; $i <= $length; $i++) {
            $this->climate->inline(".");
            sleep(1);
        }
        echo PHP_EOL;
    }

    public function getInput(array $decisions, string $message = "Select option")
    {
        return $this->climate->radio($message, $decisions)->prompt();
    }

    public function displayShootoutInfo(Collection $team1, Collection $team2): void
    {
        $climate = new CLImate();
        $data = [];
        foreach ($team1->merge($team2) as $member) {
            $member = $member->getDisplayInfo();
            $being['name'] = $member[0];
            $being['weapon strength'] = $member[1];
            $being['defence'] = $member[2];
            array_push($data, $being);
        }
        $climate->table($data);
    }
}
