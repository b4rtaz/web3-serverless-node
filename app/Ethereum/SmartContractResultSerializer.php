<?php

namespace App\Ethereum;

use Ethereum\DataType\EthD;
use Ethereum\DataType\EthS;

class SmartContractResultSerializer
{
    public function serialize($rawResult)
    {
        if ($rawResult instanceof EthS)
        {
            return $rawResult->val();
        }
        if ($rawResult instanceof EthD)
        {
            return $rawResult->hexVal();
        }
        if (is_array($rawResult))
        {
            $result = [];
            foreach ($rawResult as $key => $value)
            {
                $result[$key] = $this->serialize($value);
            }
            return $result;
        }
        throw new \Exception('Not supported type: ' . get_class($result));
    }
}
