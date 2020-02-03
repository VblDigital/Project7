<?php

namespace App\Service;

class CacheService
{
    public function cacheResponse($response)
    {
        $cache = $response->setSharedMaxAge(3600);
        $cache->headers->addCacheControlDirective('must-revalidate', true);

        return $cache;
    }


}