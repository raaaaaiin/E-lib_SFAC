<?php


namespace App\Traits;

use App\Models\Subscriber;
use Rennokki\QueryCache\Traits\QueryCacheable;

trait CustomCache
{
    //use QueryCacheable;
    protected $cacheFor = 100; // 5 minutes
    protected static $flushCacheOnUpdate = true;
}
