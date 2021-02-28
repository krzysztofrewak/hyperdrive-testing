<?php

declare(strict_types=1);

namespace Hyperdrive\Tutorial;

use Hyperdrive\Combat\Combat;
use Hyperdrive\Combat\Enemies;
use Hyperdrive\Output\OutputContract;
use Hyperdrive\Pilot\Pilot;
use Hyperdrive\Ship\Ship;

class Tutorial
{

    protected OutputContract $output;
    private Pilot $player;
    private Ship $playerShip;

    /**
     * Tutorial constructor.
     * @param OutputContract $output
     * @param Pilot $player
     * @param Ship $playerShip
     */
    public function __construct(OutputContract $output, Pilot $player, Ship $playerShip)
    {
        $this->output = $output;
        $this->player = $player;
        $this->playerShip = $playerShip;
        $this->choiceTutorial();
    }


    public function choiceTutorial(): void
    {
        $this->output->write("");
        $this->output->info("Hello and welcome to the game tutorial.");
        $this->output->info("Here you will learn the basics of the game.");
        $this->output->info("Lets start with controls. Use arrows to choose the option that you want.");
        $this->output->info("After selecting the option that you want, press ENTER to confirm your choice and proceed further.");
        $this->output->info("During your playthrough you will travel from planet to planet in order to deliver cargos to their destination.");
        $this->output->info("You will also experience many random events while travelling, such as an attack by other spaceships.");
        $this->output->info("You will also need to refuel and repair your ship at certain moments.");
        $this->output->info("In order to do that you will need to land on planets and choose an appropriate option.");
        $this->output->info("Lets try it!");

        while (true)
        {
            $options = ["one" => "Option Number 1","two" => "Option Number 2","three" => "Option Number 3"];
            $result = $this->output->getCli()->radio("Select option number 2 to proceed:", $options)->prompt();

            if ($result === "two")
            {
                break;
            }
        }
        $this->fightTutorial();


    }

    public function fightTutorial(): void
    {
        $this->output->write("");
        $this->output->info("Great job!");
        $this->output->info("Now lets move to combat tutorial.");
        $this->output->info("Here you will fight other spaceships. Your enemies will be listed on the screen.");
        $this->output->info("You will see their NUMBER, and the amount of SHIELDS and HULL INTEGRITY they have.");
        $this->output->info("To destroy a ship, you need to lower it's HULL INTEGRITY to 0 or less.");
        $this->output->info("Before you can damage the ship directly you need to lower it's SHIELDS to 0 or less.");
        $this->output->info("You will be asked to type the NUMBER of a ship you want to attack.");
        $this->output->info("Then you will choose how to attack the ship. MISSILES deal more damage overall, however their damage is halved against shields.");
        $this->output->info("So it's recommended to use LASERS against targets that still have active SHIELDS.");
        $this->output->info("After you deal damage to an enemy ship, the enemy ships take their turn to attack you.");
        $this->output->info("You will be informed how much damage you took after each attack.");
        $this->output->info("The combat will continue until either side is defeated.");

        $enemies = new Enemies($this->output);
        $combat = new Combat($this->output);
        $combat->fight(player: $this->player,playerShip: $this->playerShip,enemies: $enemies->getEnemyShips());
        $this->output->info("Great job! Now that you've finished the tutorial, you are ready to play the game.");
        $this->output->info("Good luck and have fun!");

    }


}