<?php

namespace App\Tests\Service;

use app\Service\ApiUserService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApiUserServiceTest extends KernelTestCase
{
    public function testGetUserByEmail()
    {
        self::bootKernel();
        $container = static::getContainer();

        $apiService = $container->get(ApiUserService::class);
        $api = $apiService->getUser('aude');

        $result = trim(ob_get_clean());

        //ce qu'il y'a dans la variable $result est égal à ce qu'il y'a dans la variable $api
        $this->assertEquals($api, $result);
        
        return $result;
    }
   /*   public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }  */
}
