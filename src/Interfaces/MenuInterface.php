<?php

declare(strict_types=1);

namespace Hyperdrive\Interfaces;

interface MenuInterface
{
    public function __construct();

    /**
     * @return void
     */
    public function handleMenu(): void;

    /**
     * @return void
     */
    public function displayMenu(): void;

    /**
     * @return string
     */
    public function getResult(): string;
}