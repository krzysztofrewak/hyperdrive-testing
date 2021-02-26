<?php

declare(strict_types=1);

namespace Hyperdrive\Events;

use Hyperdrive\Combat\Combat;
use Hyperdrive\Combat\Enemies;
use Hyperdrive\Geography\Planet;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Output\OutputContract;
use Hyperdrive\Pilot\Pilot;
use Hyperdrive\Quest\Cargo;
use Hyperdrive\Quest\Quest;
use Hyperdrive\Quest\QuestLog;
use Hyperdrive\Ship\Ship;
use League\CLImate\CLImate;

class Event
{
    protected OutputContract $output;

    /**
     * Event constructor.
     * @param OutputContract $output
     */
    public function __construct(OutputContract $output)
    {
        $this->output = $output;
    }


    public function randomSpaceEvents(Pilot $player,Ship $playerShip, Planet $currentPlanet,Planet $randomPlanet,QuestLog $questlog): void
    {
        $random = rand(1,10);

        if($random == 8)
        {
            $this->output->write("You encountered a merchant's ship in need of repairs. They ask of you to deliver their cargo and you will be rewarded with half of their payment.");
            $options = ["Yes" => "Yes", "No" => "No"];
            $result = $this->output->getCli()->radio("Do you agree to help them and deliver their cargo?", $options)->prompt();

            if ($result === "Yes")
            {
                $this->output->write("You agreed to deliver their cargo.");
                $questlog->addQuest(new Quest(cargo: $questlog->getRandomCargo(), destination: $randomPlanet, completed: false, main: false, exp: 2500, reward: $questlog->generateReward()));
            }
            if ($result === "No")
            {
                $this->output->write("The merchant wasn't happy with your reply but you decided it's not your problem that he has a broken ship. You decide to leave him alone.");
            }

        }
        if($random == 9)
        {
            $this->output->info("You encountered an Asteroid belt! You lost some fuel while trying to maneuver through them.");
            $fuelLost = 5 * (10 - $player->getSkill());
            $playerShip->loseFuel($fuelLost);
        }
        if($random == 10)
        {
            $this->output->info("You've been attacked!");
            $enemies = new Enemies($this->output);
            $combat = new Combat($this->output);
            $combat->landingOrFighting($player,$playerShip,$enemies->getEnemyShips(),$currentPlanet);
        }

    }

    public function randomLandEvents(Pilot $player,Ship $playerShip, Planet $currentPlanet,Planet $randomPlanet,QuestLog $questlog): void
    {
        $random = rand(1,10);

        if($random == 7)
        {
            $creditsLost = rand(0,200)+1000;
            $this->output->write("You were attacked while walking through the city");
            $this->output->info("You lost $creditsLost credits");
            $player->payCredits($creditsLost);
        }
        if($random == 8)
        {
            $reputationCheck = rand(1,10);
            $event = rand(1,3);
            $bounty = $player->calculateBounty();
            if($player->getReputation()>$reputationCheck)
            {
                $this->output->write("Your reputation has caught up to you.");
                if($event==1)
                {
                    $this->output->write("A old mechanic approached you and recognized you. You know this man but you don't know from where.");
                    $this->output->write("He told you about his new mechanism of shield boosting and asked you to test it for him.");
                    $this->output->write("You wanted to say 'No' but then you remembered that you owe him a favor so you agreed.");
                    $this->output->info("Your shield were temporarily boosted by 30");
                    $playerShip->setShields($playerShip->getShields()+30);
                }

                if($event==2)
                {
                    $this->output->write("You were approached by a bounty hunter");
                    $this->output->write("He said that you have a bounty on your head but for a price he can pretend you two never met.");


                    if($player->getCredits()<$bounty)
                    {
                        $this->output->info("That's too bad partner...");
                        $this->output->write("The next thing you heard was a shot from his blaster.");
                        $this->output->info("You've met your demise.");
                        exit(0);
                    }
                    if($player->getCredits()>$bounty)
                    {
                        $player->payCredits($bounty);
                        $this->output->info("You pay the man $bounty credits and he walks away");

                    }

                }
                if($event==3)
                {
                    //TBD
                }
            }
        }
        if($random == 9)
        {
            $this->output->info("You spotted a few people playing cards. You approach their table.");
            $options = ["Yes" => "Yes", "No" => "No"];
            $result = $this->output->getCli()->radio("Do you want to play some cards?", $options)->prompt();

            if ($result === "Yes")
            {
                $this->output->write("You decide to gamble some money");
                $credits = $this->output->getCli()->input("How much do you want to gamble?");
                $win = rand(1,2);
                if($win == 1)
                {
                    $this->output->info("You won! You earned $credits");
                    $player->earnCredits($credits);
                }
                if($win == 2)
                {
                    $this->output->info("You lost! You lost $credits");
                    $player->payCredits($credits);
                }
            }
            if ($result === "No")
            {
                $this->output->write("You decide to leave the players alone. You are above gambling.");
            }



        }
        if($random == 10)
        {
            $this->output->info("You spotted an ad for pod racing.");
            $this->output->info("You decide to compete in the race.");
            $bestPilot = rand(1,10);

            if($player->getSkill() > $bestPilot)
            {
                $this->output->info("You won the race by beating all other racers.");
                $this->output->info("You earned 1000 credits.");
                $player->earnCredits(1000);
            }
            if($player->getSkill() < $bestPilot)
            {
                $this->output->info("You lost the race.");
                $this->output->info("You didn't lose anything other than time.");
            }
        }
    }


}