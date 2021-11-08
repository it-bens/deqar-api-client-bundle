<?php

declare(strict_types=1);

namespace ITB\DeqarApiClientBundle\Tests;

use Exception;
use ITB\DeqarApiClientBundle\ITBDeqarApiClientBundle;
use ITB\DeqarApiClientBundle\Tests\Mock\SerializerMock;
use ITB\DeqarApiClientBundle\Tests\Mock\ValidatorMock;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ITBDeqarApiClientBundleKernel extends Kernel
{
    /**
     * @phpstan-ignore-next-line
     * @var array|null
     */
    private ?array $deqarApiClientConfig;

    /**
     * @phpstan-ignore-next-line
     * @param string $environment
     * @param bool $debug
     * @param array|null $deqarApiClientConfig
     */
    public function __construct(string $environment, bool $debug, ?array $deqarApiClientConfig = null)
    {
        parent::__construct($environment, $debug);
        $this->deqarApiClientConfig = $deqarApiClientConfig;
    }

    /**
     * @return string
     */
    public function getCacheDir(): string
    {
        return __DIR__ . '/cache/' . spl_object_hash($this);
    }

    /**
     * @return BundleInterface[]
     */
    public function registerBundles(): array
    {
        return [
            new ITBDeqarApiClientBundle(),
        ];
    }

    /**
     * @param LoaderInterface $loader
     * @throws Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(function (ContainerBuilder $container) {
            if (null !== $this->deqarApiClientConfig) {
                $container->loadFromExtension('itb_deqar_api_client', $this->deqarApiClientConfig);
            }

            $httpClientDefinition = new Definition(MockHttpClient::class);
            $httpClientDefinition->setPublic(true);
            $container->register(HttpClientInterface::class, MockHttpClient::class);

            $serializerDefinition = new Definition(SerializerMock::class);
            $serializerDefinition->setPublic(true);
            $container->register(SerializerInterface::class, SerializerMock::class);

            $validatorDefinition = new Definition(ValidatorMock::class);
            $validatorDefinition->setPublic(true);
            $container->register(ValidatorInterface::class, ValidatorMock::class);

            $cacheDefinition = new Definition(ArrayAdapter::class);
            $cacheDefinition->setPublic(true);
            $container->register('itb_deqar_api_client.test_cache', ArrayAdapter::class);

            $container->addDefinitions(
                [
                    'http_client' => $httpClientDefinition,
                    'serializer' => $serializerDefinition,
                    'validator' => $validatorDefinition
                ]
            );
        });
    }
}
