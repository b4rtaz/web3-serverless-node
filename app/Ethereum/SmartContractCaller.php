<?php

namespace App\Ethereum;

class SmartContractCaller
{
    public function __construct(
        private SmartContractProvider $contractProvider,
        private SmartContractParametersConverter $parametersConverter,
        private SmartContractResultSerializer $serializer)
    {
    }

    public function callMethod(string $contractName, string $methodName, array $rawParameters)
    {
        $contract = $this->contractProvider->get($contractName);

        $parameters = $this->parametersConverter->convert($rawParameters);

        $rawResult = $contract->callMethod($methodName, $parameters);

        $result = $this->serializer->serialize($rawResult);

        return $result;
    }
}
