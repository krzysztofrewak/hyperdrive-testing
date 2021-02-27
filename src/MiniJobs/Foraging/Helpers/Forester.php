<?php

declare(strict_types=1);

namespace Hyperdrive\MiniJobs\Foraging\Helpers;

trait Forester
{
    protected function runForester(): void
    {
        $treesCount = rand(50, 300);
        for ($i = 0; $i < $treesCount; $i++) {
            $this->area->add("tree");
        }
    }

    protected function addFlora(): void
    {
        $foodCount = rand(20, 150);
        $food = ["berries", "strawberries", "honey", "mushroom"];

        for ($i = 0; $i < $foodCount; $i++) {
            $type = array_rand($food);
            $this->area->add($food[$type]);
        }
    }

    protected function addFauna(): void
    {
        $animalsCount = rand(20, 50);
        $threats = ["bear", "wolf", "hobo", "forest guard"];
        for ($i = 0; $i < $animalsCount; $i++) {
            $type = array_rand($threats);
            $this->area->add($threats[$type]);
        }
    }
}