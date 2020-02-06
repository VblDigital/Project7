<?php

namespace App\Service;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use \Psr\Cache\InvalidArgumentException;

class CacheService
{
    const EXPIRE_CACHE = 3600;

    /** @var AdapterInterface  */
    private $adapter;

    /**
     * CacheService constructor.
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param $key
     * @param $data
     * @throws InvalidArgumentException
     */
    public function saveItem($key, $data)
    {
        $item = $this->adapter->getItem($key);
        $item->expiresAfter(self::EXPIRE_CACHE);
        $item->set($data);
        $this->adapter->save($item);
    }
}
