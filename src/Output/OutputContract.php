<?php

namespace Hyperdrive\Output;

interface OutputContract
{
    function write(String $message);
    function info(String $message);
}