<?php

namespace App\Services;

//use App\Models\Storage\Storage;

use App\DTO\Storage\File;
use App\DTO\Storage\Folder;
use App\Models\Storage\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage as StorageFacade;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use function Symfony\Component\Translation\t;

class StorageService
{
    public FilesystemAdapter|Filesystem $disk;

    public function __construct()
    {
        $this->disk = StorageFacade::disk("user-drive");
    }

    public function getDirectoryUsedSized(Storage $storage): float
    {
        return $this->getStorageSubFolder($storage->path)->getSize();
    }

    public function getStorageSubFolder(string $path): Folder
    {
        $files = collect($this->getDisk()->files($path))->map(function (string $path) {
            return new File($this->getSize($path), $path);
        });
        $folders = collect($this->getDisk()->directories($path));

        $folder = new Folder();
        $folder
            ->setPath($path)
            ->setFiles($files)
            ->setFolders(
                $folders->isNotEmpty() ? $folders->map(function (string $path) use (&$folder) {
                    $sub = $this->getStorageSubFolder($path);
                    $size = $sub->getFiles()->sum(function (File $file) {
                            return $file->getSize();
                        }) + $sub->getFolders()->sum(function (Folder $folder) {
                            return $folder->getSize();
                        });
                    $folder->incrementSize($size);
                    return $sub;
                }) : collect()
            )
            ->setSize($folder->getFiles()->sum(function (File $file) {
                    return $file->getSize();
                }) + $folder->getFolders()->sum(function (Folder $folder) {
                    return $folder->getSize();
                }));
        return $folder;
    }

    public function getDisk()
    {
        return $this->disk;
    }

    public function addFileToStorage(Storage $storage, string $path, string $data): bool|string
    {
        return $this->getDisk()->put($storage->path."/".$path, $data);
    }

    public function getSize(string $path): int
    {
        return $this->disk->size($path);
    }

    public function guessName(UploadedFile $file): string
    {
        $extension = $file->guessExtension();
        $nameWithClientExtension = $file->getClientOriginalName();
        $name = explode(".",$nameWithClientExtension);
        array_pop($name);
        return implode("",$name) . "." . $extension;
    }
}
