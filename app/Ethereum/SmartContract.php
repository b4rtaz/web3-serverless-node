<?php

namespace App\Ethereum;

use Ethereum\Ethereum as EthereumClient;
use Ethereum\SmartContract as SmartContractClient;

class SmartContract
{
    /**
     * @var SmartContractClient
     */
    private $client;

    public function __construct(
        string $rpcUrl,
        string $address,
        private array $abi)
    {
        $eth = new EthereumClient($rpcUrl);
        $this->client = new SmartContractClient($this->abi, $address, $eth);
    }

    public function callMethod(string $methodName, array $parameters)
    {
        $result = call_user_func_array([$this->client, $methodName], $parameters);

        if (!is_array($result))
        {
            return $result;
        }

        $methodAbi = $this->getMethodAbi($methodName);

        $outputNames = [];
        foreach ($methodAbi->outputs as $item) {
            $outputNames[] = $item->name;
        }

        return array_combine($outputNames, $result);
    }

    private function getMethodAbi(string $methodName)
    {
        foreach ($this->abi as $item)
        {
            if ($item->type === 'function' && 
                $item->name === $methodName)
            {
                return $item;
            }
        }
        throw new \Exception('Called undefined contract method ' . $methodName);
    }
}
