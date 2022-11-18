<?php

namespace App\DTO\Storage;

use Illuminate\Support\Collection;

class Folder
{
    private string $path;
    private Collection $files;
    private Collection $folders;
    private int $size;

    public function __construct()
    {
        $this->size = 0;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function getFolders(): Collection
    {
        return $this->folders;
    }

    public function setFolders(Collection $folders): self
    {
        $this->folders = $folders;
        return $this;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function incrementSize(int $size): void
    {
        $this->size += $size;
    }

    public function setFiles(Collection $files): self
    {
        $this->files = $files;
        return $this;
    }

    public function getFiles(): Collection
    {
        return $this->files;
    }
}
