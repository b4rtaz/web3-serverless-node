<?php

namespace App\Ethereum;

use Ethereum\DataType\EthD;

class SmartContractParametersConverter
{
    public function convert(array $rawParameters): array
    {
        $parameters = [];

        foreach ($rawParameters as $rawParameter)
        {
            if (strpos($rawParameter, '0x') === 0)
            {
                $parameters[] = new EthD($rawParameter);
            }
            else
            {
                throw new \Exception('Numbers are supported only');
            }
        }

        return $parameters;
    }
}
