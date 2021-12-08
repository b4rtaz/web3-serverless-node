<?php

namespace App\Ethereum;

use App\Core\ConfigurationProvider;

class SmartContractProvider
{
    private static $cache = [];

    public function __construct(
        private ConfigurationProvider $configurationProvider)
    {
    }

    public function get(string $contractName): SmartContract
    {
        if (!array_key_exists($contractName, self::$cache))
        {
            $contractConfig = $this->configurationProvider->get('smartContracts', $contractName);
            $networkConfig = $this->configurationProvider->get('ethereumNetworks', $contractConfig['networkName']);

            $abiRaw = $this->readAbi($contractConfig['abiFileName']);
            $abi = json_decode($abiRaw, false);

            self::$cache[$contractName] = new SmartContract($networkConfig['rpcUrl'], $contractConfig['address'], $abi);
        }
        return self::$cache[$contractName];
    }

    private function readAbi(string $fileName)
    {
        $path = APP_PATH . '/../storage/abi/' . $fileName;
        $abi = file_get_contents($path);
        if ($abi === false)
        {
            throw new \Exception('Cannot read abi ' . $path);
        }
        return $abi;
    }
}
