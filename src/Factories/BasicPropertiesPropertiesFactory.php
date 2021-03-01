<?php

namespace Hyperdrive\Factories;

use Hyperdrive\PLanetProperties\Cantors\ImperialCantor;
use Hyperdrive\PLanetProperties\Cantors\RepublicanCantor;
use Hyperdrive\Payment\Currency\RepublicanCredit;
use Hyperdrive\PlanetProperties\Dealers\EnginesDealers\BasicEngineDealers;
use Hyperdrive\PlanetProperties\Dealers\EnginesDealers\UpgradedEngineDealer;
use Hyperdrive\PlanetProperties\Dealers\FuelDealers\BasicFuelDealer;
use Hyperdrive\Payment\Currency\ImperialCredit;
use Hyperdrive\PlanetProperties\Dealers\FuelDealers\SuperFuelDealer;
use Hyperdrive\PlanetProperties\Dealers\FuelTankDealers\LargeFuelTankDealer;
use Hyperdrive\PlanetProperties\Dealers\FuelTankDealers\MiddleFuelTankDealer;
use Hyperdrive\PlanetProperties\Dealers\FuelTankDealers\SmallFuelTankDealer;
use Hyperdrive\PlanetProperties\Dealers\SpaceCraftsDealers\BasicCombatSpaceCraftDealer;
use Hyperdrive\PlanetProperties\Dealers\SpaceCraftsDealers\BasicHybridSpaceCraftDealer;
use Hyperdrive\PlanetProperties\Dealers\SpaceCraftsDealers\BasicTrademarkSpaceCraftDealer;
use Hyperdrive\PlanetProperties\Dealers\SpaceCraftsDealers\UpgradedCombatSpaceCraftDealer;
use Hyperdrive\PlanetProperties\Dealers\SpaceCraftsDealers\UpgradedHybridSpaceCraftDealer;
use Hyperdrive\PlanetProperties\Dealers\SpaceCraftsDealers\UpgradedTrademarkSpaceCraftDealer;
use Hyperdrive\PlanetProperties\Dealers\WeaponsDealers\BasicLaserDealer;
use Hyperdrive\PlanetProperties\Dealers\WeaponsDealers\UpgradedLaserDealer;
use Hyperdrive\PlanetProperties\QuestGivers\IronOreTransportQuestGiver;

class BasicPropertiesPropertiesFactory implements PropertiesFactory
{
    public function createRandomProperties(): array
    {
        $collection = [];

        $result = rand(1,2);
        if ($result === 1){
            $collection[BasicFuelDealer::class] = new BasicFuelDealer(ImperialCredit::class);
        }

        $result = rand(1,2);
        if ($result === 1){
            $collection[SuperFuelDealer::class] = new SuperFuelDealer(RepublicanCredit::class);
        }

        $result = rand(1,2);
        if ($result === 1){
            $collection[BasicEngineDealers::class] = new BasicEngineDealers(ImperialCredit::class);
        }

        $result = rand(1,2);
        if ($result === 1){
            $collection[UpgradedEngineDealer::class] = new UpgradedEngineDealer(RepublicanCredit::class);
        }

        $result = rand(1,2);
        if ($result === 1){
            $collection[LargeFuelTankDealer::class] = new LargeFuelTankDealer(ImperialCredit::class);
        }

        $result = rand(1,2);
        if ($result === 1){
            $collection[MiddleFuelTankDealer::class] = new MiddleFuelTankDealer(ImperialCredit::class);
        }

        $result = rand(1,2);
        if ($result === 1){
            $collection[SmallFuelTankDealer::class] = new SmallFuelTankDealer(RepublicanCredit::class);
        }

        $result = rand(1,2);
        if ($result === 1){
            $collection[UpgradedTrademarkSpaceCraftDealer::class]
                = new UpgradedTrademarkSpaceCraftDealer(RepublicanCredit::class,);
        }

        $result = rand(1,2);
        if ($result === 1){
            $collection[UpgradedLaserDealer::class]
                = new UpgradedLaserDealer(RepublicanCredit::class);
        }

        $result = rand(1,2);
        if ($result === 1){
            $collection[BasicLaserDealer::class]
                = new BasicLaserDealer(RepublicanCredit::class);
        }

        $result = rand(1,2);
        if ($result === 1){
            $collection[BasicTrademarkSpaceCraftDealer::class]
                = new BasicTrademarkSpaceCraftDealer(ImperialCredit::class);
        }

        $result = rand(1,2);
        if ($result === 1){
            $collection[BasicHybridSpaceCraftDealer::class]
                = new BasicHybridSpaceCraftDealer(ImperialCredit::class);
        }

        $result = rand(1,2);
        if ($result === 1){
            $collection[UpgradedHybridSpaceCraftDealer::class]
                = new UpgradedHybridSpaceCraftDealer(ImperialCredit::class);
        }

        $result = rand(1,2);
        if ($result === 1){
            $collection[UpgradedCombatSpaceCraftDealer::class]
                = new UpgradedCombatSpaceCraftDealer(ImperialCredit::class);
        }

        $result = rand(1,2);
        if ($result === 1){
            $collection[BasicCombatSpaceCraftDealer::class]
                = new BasicCombatSpaceCraftDealer(ImperialCredit::class);
        }

        $collection[IronOreTransportQuestGiver::class]
            = new IronOreTransportQuestGiver();

        return $collection;
    }
}