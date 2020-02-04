<?php

namespace App\Service;

use Symfony\Component\Cache\Adapter\AdapterInterface;

class CacheService
{
    const EXPIRE_CACHE = 3600;

    private $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function saveItem($key, $data)
    {
        $item = $this->adapter->getItem($key);
        $item->expiresAfter(self::EXPIRE_CACHE);
        $item->set($data);
        $this->adapter->save($item);
    }
}
