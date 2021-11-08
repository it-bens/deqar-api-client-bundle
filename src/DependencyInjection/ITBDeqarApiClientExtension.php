<?php

declare(strict_types=1);

namespace ITB\DeqarApiClientBundle\DependencyInjection;

use Exception;
use ITB\DeqarApiClient\SubmissionApi\SubmissionApiClientInterface;
use ITB\DeqarApiClient\WebApi\CachedWebApiClient;
use ITB\DeqarApiClient\WebApi\WebApiClientInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

final class ITBDeqarApiClientExtension extends Extension
{
    /**
     * @phpstan-ignore-next-line
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        /** @phpstan-ignore-next-line */
        $config = $this->processConfiguration($configuration, $configs);

        // WebApi client registration
        if (isset($config['web_api_client'])) {
            $webApiClientConfig = $config['web_api_client'];

            $webApiClientDefinition = $container->getDefinition('itb_deqar_api_client.web_api_client');
            $webApiClientDefinition->replaceArgument(0, $webApiClientConfig['deqar_username']);
            $webApiClientDefinition->replaceArgument(1, $webApiClientConfig['deqar_password']);

            $container->setAlias(WebApiClientInterface::class, 'itb_deqar_api_client.web_api_client');
            //$container->register(WebApiClientInterface::class, 'itb_deqar_api_client.web_api_client');

            if (isset($webApiClientConfig['cache'])) {
                $cachedWebApiClientDefinition = new Definition(CachedWebApiClient::class);
                $cachedWebApiClientDefinition->setArgument(0, new Reference('itb_deqar_api_client.web_api_client'));
                $cachedWebApiClientDefinition->setArgument(1, new Reference($webApiClientConfig['cache']));
                $cachedWebApiClientDefinition->setPublic(false);
                $container->setDefinition('itb_deqar_api_client.web_api_client_cached', $cachedWebApiClientDefinition);

                $container->setAlias(WebApiClientInterface::class, 'itb_deqar_api_client.web_api_client_cached');
            }
        }

        // SubmissionApi client registration
        if (isset($config['submission_api_client'])) {
            $submissionApiClientConfig = $config['submission_api_client'];

            $submissionApiClientDefinition = $container->getDefinition('itb_deqar_api_client.submission_api_client');
            $submissionApiClientDefinition->replaceArgument(0, $submissionApiClientConfig['deqar_username']);
            $submissionApiClientDefinition->replaceArgument(1, $submissionApiClientConfig['deqar_password']);
            $submissionApiClientDefinition->replaceArgument(5, $submissionApiClientConfig['test']);

            $container->setAlias(SubmissionApiClientInterface::class, 'itb_deqar_api_client.submission_api_client');

            // SubmissionApi validators are registered within validators.xml
            $loader->load('validators.xml');
        }
    }

    public function getAlias(): string
    {
        return 'itb_deqar_api_client';
    }
}
