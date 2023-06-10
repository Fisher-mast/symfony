<?php

namespace App\Controller;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(
        CacheInterface         $myDedicatedCache,
        TagAwareCacheInterface $myDedicated2Cache,
        CacheItemPoolInterface $myDedicated3Cache,
    ): Response {
        $item = $myDedicatedCache->getItem('test');
        $item->set('test');
        $myDedicatedCache->save($item);
        $item2 = $myDedicatedCache->getItem('test2');

        $item3 = $myDedicated2Cache->getItem('test3');
        $item3->set('test3');
        $item3->tag('tag3');
        dd($myDedicatedCache, $myDedicated2Cache, $myDedicated3Cache);
    }
}
