<?php

namespace App\Core;

class ForeverCacheItem
{
    public function __construct(
        public bool $isExists,
        public bool $isRecent,
        public $value)
    {
    }
}
