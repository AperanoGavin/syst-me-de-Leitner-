<?php

namespace App\Tests\Service;

use App\Service\ApiUserService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApiUserServiceTest extends KernelTestCase
{
    public function testGetUserByEmail()
    {
        self::bootKernel();
        $container = static::getContainer();  
        $apiService = $container->get(ApiUserService::class);

        $api = $apiService->getUser('audesandrine6@gmail.com');
        $result = trim(ob_get_clean());
        //dd($api);
        //ce qu'il y'a dans la variable $result est égal à ce qu'il y'a dans la variable $api
        $this->assertEquals($api[0]['email'], $result);
        
        return $result;
    }
    /*  public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }  */
}
