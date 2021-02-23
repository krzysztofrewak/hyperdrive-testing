<?php


namespace Hyperdrive\Entity;


use Hyperdrive\Entity\Players\Player;

class Task
{
    public function itemToTransport($atlas,$ship,$cli,$planet,$trap){
        $planetToTransportItem = (string)$atlas->getRandomPlanet();
        $ship->setTarget($planetToTransportItem);
        $ship->setItemToTransport("Natrium");
        $cli->info("Target to transport ".$ship->getItemToTransport(). " is ".$ship->getTarget()."\n");

        if($planet === $planetToTransportItem) {
            if($ship->getFuel()<=90) $ship->setFuel(rand(1,10));
            if($ship->getCondition()<=90) $ship->setCondition(rand(1,10));
            $trap->unloading();
            $ship->setItemToTransport(null);
        }
    }

    public function questMissions($quest,$ship,$person,$planet,Player $player){
        $quest->getVisitPlanets()->missionStatement($ship,$person,$player);
        $quest->getVisitPlanets()->setCountPlanet(1);
        $quest->getSpendTokens()->missionStatement($ship,$person,$player);
        $quest->getSpendTokens()->setTokenCount($planet->getPrice());
    }

    public function shipInformation($ship,$cli){
        $ship->setFuel(rand(-2,-8));
        $ship->setCondition(rand(-2,-8));
        $cli->info("".$ship);
    }

    public function setPersonItems($person, $planet){
        $person->setToken(-($planet->getPrice()));
        $person->setLogs($planet);
    }
}