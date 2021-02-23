<?php

declare(strict_types=1);

namespace Hyperdrive\Traits;

trait Identifier
{
    protected int $id;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
