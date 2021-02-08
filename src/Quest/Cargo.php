<?php

declare(strict_types=1);

namespace Hyperdrive\Quest;


class Cargo
{
    protected string $name;

    /**
     * Cargo constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }



}