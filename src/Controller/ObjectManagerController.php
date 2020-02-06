<?php

namespace App\Controller;

use App\Service\CacheService;
use Doctrine\Persistence\ObjectManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class ObjectManagerController extends AbstractFOSRestController
{
    /** @var AdapterInterface */
    protected $em;
    /** @var CacheService */
    protected $cache;
    /** @var ObjectManager */
    protected $adapter;

    /**
     * ObjectManagerController constructor.
     * @param ObjectManager $em
     * @param AdapterInterface $adapter
     * @param CacheService $cache
     */
    public function __construct(ObjectManager $em, AdapterInterface $adapter, CacheService $cache)
    {
        $this->em = $em;
        $this->cache = $cache;
        $this->adapter = $adapter;
    }
}
