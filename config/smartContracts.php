<?php

return [
    'eth-wbnb-pancake-pair' => [
        'networkName' => 'bsc-mainnet',

        /**
         * Contract address.
         */
        'address' => '0x74e4716e431f45807dcf19f284c7aa99f18a4fbc',

        /**
         * ABI file name in /storage/abi folder.
         */
        'abiFileName' => 'pancake_pair_abi.json',

        /**
         * Allowed contract methods, null - all methods are allowed.
         */
        'allowedMethods' => ['getReserves', 'name'],

        /**
         * Time to live in seconds, 0 - no cache.
         */
        'cacheTtl' => 60
    ]
];
