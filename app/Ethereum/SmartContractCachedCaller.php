<?php

namespace App\Ethereum;

use App\Core\ConfigurationProvider;
use App\Core\ForeverCache;

class SmartContractCachedCaller
{
    public function __construct(
        private SmartContractCaller $caller,
        private ConfigurationProvider $configurationProvider,
        private ForeverCache $cache)
    {
    }

    public function callMethod(string $contractName, string $methodName, array $rawParameters)
    {
        $cacheKey = 'callMethod|' . implode('|', array_merge([$contractName, $methodName], array_values($rawParameters)));

        $config = $this->configurationProvider->get('smartContracts', $contractName);
        $ttl = $config['cacheTtl'];

        if ($ttl > 0)
        {
            $cacheItem = $this->cache->get($cacheKey, $ttl);
            if ($cacheItem->isRecent)
            {
                return $cacheItem->value;
            }
        }

        try
        {
            $value = $this->caller->callMethod($contractName, $methodName, $rawParameters);

            if ($ttl > 0)
            {
                $this->cache->set($cacheKey, $value);
            }
            return $value;
        }
        catch (\Exception $ex)
        {
            if ($ttl > 0 && $cacheItem->isExists)
            {
                return $cacheItem->value;
            }
            throw $ex;
        }
    }
}
