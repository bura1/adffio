<?php

namespace App\Service;

use Gedmo\Sluggable\Util\Urlizer;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\Visibility;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileHelper
{
    const AD_IMAGE = 'ad_image';
    private FilesystemOperator $filesStorage;

    public function __construct(FilesystemOperator $filesStorage)
    {
        $this->filesStorage = $filesStorage;
    }

    public function uploadAdImage(File $file): string
    {
        return $this->uploadFile($file, self::AD_IMAGE);
    }

    public function readFile(string $path)
    {
        return $this->filesStorage->readStream($path);
    }

    public function deleteFile(string $path): void
    {
        $this->filesStorage->delete($path);
    }

    private function uploadFile(File $file, string $directory): string
    {
        if ($file instanceof UploadedFile) {
            $originalFilename = $file->getClientOriginalName();
        } else {
            $originalFilename = $file->getFilename();
        }
        $newFilename = Urlizer::urlize(pathinfo($originalFilename, PATHINFO_FILENAME)).'-'.uniqid().'.'.$file->guessExtension();

        $stream = fopen($file->getPathname(), 'r');

        try {
            $this->filesStorage->writeStream(
                $directory . '/' . $newFilename,
                $stream,
                [
                    'visibility' => Visibility::PRIVATE
                ]
            );
        } catch (FilesystemException $e) {
            throw new \Exception(sprintf('Neuspješan upload datoteke "%s"', $newFilename));
        }

        if (is_resource($stream)) {
            fclose($stream);
        }

        return $newFilename;
    }
}