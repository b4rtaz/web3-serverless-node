<?php

namespace App\Core;

class FileCache
{
    const MAX_TTL = 3600;

    public function __construct()
    {
        if (random_int(0, 500) === 250)
        {
            $this->cleanUp();
        }
    }

    public function set(string $key, $value)
    {
        $path = $this->getCachePath($key);
        file_put_contents($path, serialize($value));
    }

    public function tryGet(string $key, int $ttl)
    {
        if ($ttl > self::MAX_TTL)
        {
            throw new \Exception('Ttl is higher than max value');
        }

        $path = $this->getCachePath($key);
        if (file_exists($path) && time() - $ttl < filemtime($path))
        {
            return unserialize(file_get_contents($path));
        }
        return null;
    }

    private function cleanUp()
    {
        $dirPath = $this->getDirectoryPath();
        $fileNames = scandir($dirPath);
        $limit = time() - self::MAX_TTL;
        foreach ($fileNames as $fileName)
        {
            $path = $dirPath . $fileName;
            if (str_ends_with($path, '.cache') && $limit > filemtime($path))
            {
                @unlink($path);
            }
        }
    }

    private function getCachePath(string $key): string
    {
        return $this->getDirectoryPath() . md5($key) . '.cache';
    }

    private function getDirectoryPath(): string
    {
        return APP_PATH . '/../storage/cache/';
    }
}
