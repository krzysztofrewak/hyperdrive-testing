<?php

declare(strict_types = 1);

require "./vendor/autoload.php";

use Hyperdrive\Factories\BasicPropertiesPropertiesFactory;
use Hyperdrive\Factories\PLayerFactory;
use Hyperdrive\GalaxyAtlasBuilder;
use Hyperdrive\Handlers\TransportQuestHandler;
use Hyperdrive\Handlers\RefuelHandler;
use Hyperdrive\Handlers\SpaceCraftReplacementHandler;
use Hyperdrive\Handlers\SpaceCraftUpgradeHandler;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\PlanetProperties\Dealers\FuelDealers\FuelDealer;
use Hyperdrive\PlanetProperties\Dealers\SpacecraftDealer;
use Hyperdrive\PlanetProperties\Dealers\SpaceCraftElementDealer;
use Hyperdrive\PlanetProperties\QuestGivers\QuestGiver;
use Hyperdrive\Quests\QuestEnder;
use League\CLImate\CLImate;

$cli = new CLImate();

$atlas = GalaxyAtlasBuilder::buildFromYaml("./resources/routes.yaml");
$hyperdrive = new HyperdriveNavigator($atlas);

$playerFactory = new PLayerFactory();
$player = $playerFactory->createPlayer();

$planet = $hyperdrive->getRandomPlanet();
$propertiesFactory = new BasicPropertiesPropertiesFactory();

while (true) {

    $planet = $hyperdrive->getCurrentPlanet();
    $planet->setProperties($propertiesFactory->createRandomProperties());

    $questService = new QuestEnder();
    if ($questService->isFinished($player, $planet)){
        $questService->finishQuest($player);
    }

    $cli->info("You're on the $planet. You can jump to:");
    $options = $planet->getNeighbours()->toArray() + ["" => "[show more option]"];
    $result = $cli->radio("Select jump target planet", $options)->prompt();

    if (!$result) {
        $options = ["return" => "return",
            "spaceCraftInfo" => "check space craft info",
            "buySomething" => "buy something from dealer or get quest",
            "walletInfo" => "check your wallet",
            "currentQuest" => "check current quest",
            "quit" => "quit application",
            ];
        $result = $cli->radio("Select option", $options)->prompt();

        if ($result === "quit") {
            break;
        }
        elseif ($result === "spaceCraftInfo"){
            $cli->info($player->getSpaceCraft()->__toString());
        }
        elseif ($result === "walletInfo"){
            $cli->info($player->getWallet()->__toString());
        }
        elseif ($result === "currentQuest"){
            if ($player->getCurrentQuest() === null){
                $cli->info("No current quest");
            }else{
                $cli->info("Active quest direction: " . $player->getCurrentQuest()->getDirection());
            }
        }
        elseif ($result === "buySomething") {
            $properties = [];
            foreach ($planet->getProperties() as $property) {
                $properties[$property::class] = $property->getInfo();
            }
            $propertyResult = $cli->radio("Select option", $properties)->prompt();
            $chosenProperty = $planet->getProperties()[$propertyResult];

            if($chosenProperty instanceof SpaceCraftElementDealer){
                $handler = new SpaceCraftUpgradeHandler();
                $cli->info($handler->handle(player: $player,dealer: $chosenProperty));
            }
            elseif($chosenProperty instanceof FuelDealer){
                $handler = new RefuelHandler();
                $cli->info($handler->handle(player: $player,dealer: $chosenProperty, fuelQuantity: 100));
            }
            elseif($chosenProperty instanceof SpacecraftDealer){
                $handler = new SpaceCraftReplacementHandler();
                $cli->info($handler->handle(player: $player,dealer: $chosenProperty));
            }
            elseif($chosenProperty instanceof QuestGiver){
                $handler = new TransportQuestHandler();
                $cli->info($handler->handle(player: $player, giver: $chosenProperty));
            }
        }
        continue;
    }

    try {
        $player->getSpaceCraft()->fly();
        $hyperdrive->jumpTo($result);
    }
    catch (Exception $exception){
        $cli->error($exception->getMessage());
    }
}
