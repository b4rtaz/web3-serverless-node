<?php

namespace App\Core;

class ForeverCache
{
    public function set(string $key, $value)
    {
        $path = $this->getCachePath($key);
        file_put_contents($path, serialize($value));
    }

    public function get(string $key, int $ttl): ForeverCacheItem
    {
        $path = $this->getCachePath($key);
        $isExists = file_exists($path);
        try
        {
            $value = unserialize(file_get_contents($path));
        }
        catch (\Exception)
        {
            $isExists = false;
        }
        $isRecent = $isExists && (time() - $ttl < filemtime($path));

        return new ForeverCacheItem(
            $isExists,
            $isRecent,
            $value);
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
