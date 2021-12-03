<?php

namespace App\Ethereum;

use App\Core\FileCache;
use App\Core\ConfigurationProvider;

class SmartContractCachedCaller
{
    public function __construct(
        private SmartContractCaller $caller,
        private ConfigurationProvider $configurationProvider,
        private FileCache $cache)
    {
    }

    public function callMethod(string $contractName, string $methodName, array $rawParameters)
    {
        $cacheKey = 'caller|' . $methodName . '|' . implode('|', array_values($rawParameters));

        $config = $this->configurationProvider->get('smartContracts', $contractName);
        $result = $this->cache->tryGet($cacheKey, $config['cacheTtl']);
        
        if ($result === null)
        {
            $result = $this->caller->callMethod($contractName, $methodName, $rawParameters);
            $this->cache->set($cacheKey, $result);
        }
        
        return $result;
    }
}
