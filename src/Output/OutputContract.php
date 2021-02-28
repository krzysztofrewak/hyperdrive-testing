<?php

namespace Hyperdrive\Output;

interface OutputContract
{
    function write(string $message);

    function info(string $message);
}