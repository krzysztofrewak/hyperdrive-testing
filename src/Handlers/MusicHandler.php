<?php

declare(strict_types=1);

namespace Hyperdrive\Handlers;

trait MusicHandler
{
    public function playMusic(string $songName, int $songId): void
    {
        $file = "./Music/$songName$songId";
        $saveFile = fopen($file, 'w');
        fclose($saveFile);
        unlink($file);
    }
}