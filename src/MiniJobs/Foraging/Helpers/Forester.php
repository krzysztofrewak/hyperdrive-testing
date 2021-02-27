<?php


namespace Hyperdrive\MiniJobs\Foraging\Helpers;


trait Forester
{
    protected function runForester(): void
    {
        $treesCount = rand(50, 500);
        for ($i = 0; $i < $treesCount; $i++) {
            $treeLocation = rand(0, 3);
            $this->area->put($i + $treeLocation, "tree");
        }
    }
}