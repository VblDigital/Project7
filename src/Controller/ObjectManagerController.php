<?php

namespace App\Controller;

use App\Service\CacheService;
use Doctrine\Persistence\ObjectManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class ObjectManagerController extends AbstractFOSRestController
{
    protected $em;
    protected $cache;
    protected $adapter;

    public function __construct(ObjectManager $em, AdapterInterface $adapter, CacheService $cache)
    {
        $this->em = $em;
        $this->cache = $cache;
        $this->adapter = $adapter;
    }
}