<?php

namespace App\Ethereum;

use App\Core\ConfigurationProvider;

class SmartContractCaller
{
    public function __construct(
        private SmartContractProvider $contractProvider,
        private SmartContractParametersConverter $parametersConverter,
        private SmartContractResultSerializer $serializer,
        private ConfigurationProvider $configurationProvider)
    {
    }

    public function callMethod(string $contractName, string $methodName, array $rawParameters)
    {
        $allowedMethods = $this->configurationProvider->get('smartContracts', $contractName)['allowedMethods'];

        if ($allowedMethods && !in_array($methodName, $allowedMethods))
        {
            throw new \Exception('Method ' . $methodName . ' is not allowed');
        }

        $contract = $this->contractProvider->get($contractName);

        $parameters = $this->parametersConverter->convert($rawParameters);

        $rawResult = $contract->callMethod($methodName, $parameters);

        $result = $this->serializer->serialize($rawResult);

        return $result;
    }
}
