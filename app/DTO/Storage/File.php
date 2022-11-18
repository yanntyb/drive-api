<?php

namespace App\DTO\Storage;

class File
{
    private int $size;
    private string $path;

    public function __construct(int $size, string $path){
        $this->size = $size;
        $this->path = $path;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}
