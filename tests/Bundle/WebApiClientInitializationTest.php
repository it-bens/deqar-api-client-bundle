<?php

declare(strict_types=1);

namespace ITB\DeqarApiClientBundle\Bundle\Tests;

use ITB\DeqarApiClient\WebApi\WebApiClient;
use ITB\DeqarApiClient\WebApi\WebApiClientInterface;
use ITB\DeqarApiClientBundle\Tests\ITBDeqarApiClientBundleKernel;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

final class WebApiClientInitializationTest extends TestCase
{
    /** @var ContainerInterface $container */
    private ContainerInterface $container;

    public function setUp(): void
    {
        $config = Yaml::parseFile(__DIR__ . '/../Fixtures/BundleConfiguration/web_api_client_config_without_cache.yaml');
        $kernel = new ITBDeqarApiClientBundleKernel('test', true, $config);
        $kernel->boot();
        $this->container = $kernel->getContainer();
    }

    public function testServiceWiring(): void
    {
        $webApiClient = $this->container->get('itb_deqar_api_client.web_api_client');
        self::assertInstanceOf(WebApiClient::class, $webApiClient);
    }

    public function testServiceAlias(): void
    {
        $webApiClient = $this->container->get(WebApiClientInterface::class);
        self::assertInstanceOf(WebApiClient::class, $webApiClient);
    }
}
