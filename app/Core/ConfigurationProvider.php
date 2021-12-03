<?php

namespace App\Core;

class ConfigurationProvider
{
    private static $cache = [];

    public function get(string $group, string $key): int|float|string|array
    {
        if (!array_key_exists($group, self::$cache))
        {
            $path = APP_PATH . '/../config/' . $group . '.php';
            self::$cache[$group] = require $path;
        }
        $config = self::$cache[$group];
        if (!array_key_exists($key, $config))
        {
            throw new \Exception('Cannot find configuration key: ' . $key);
        }
        return $config[$key];
    }
}
