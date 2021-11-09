<?php

declare(strict_types=1);

namespace ITB\DeqarApiClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('itb_deqar_api_client');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();
        /** @phpstan-ignore-next-line */
        $rootNode
            ->children()
                ->arrayNode('web_api_client')
                    ->children()
                        ->scalarNode('deqar_username')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->info('The DEQAR username provided by EQAR')
                            ->example('%env(string:DEQAR_API_USERNAME)%')
                        ->end()
                        ->scalarNode('deqar_password')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->info('The DEQAR password provided by EQAR')
                            ->example('%env(string:DEQAR_API_PASSWORD)%')
                        ->end()
                        ->scalarNode('cache')
                            ->cannotBeEmpty()
                            ->defaultNull()
                            ->info('Id of a configured cache-pool, which will be used for WebApi result caching')
                            ->example('itb_deqar_api_client.test_cache')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('submission_api_client')
                    ->children()
                        ->scalarNode('deqar_username')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->info('The DEQAR username provided by EQAR')
                            ->example('%env(string:DEQAR_API_USERNAME)%')
                        ->end()
                        ->scalarNode('deqar_password')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->info('The DEQAR password provided by EQAR')
                            ->example('%env(string:DEQAR_API_PASSWORD)%')
                        ->end()
                        ->booleanNode('test')
                            ->defaultFalse()
                            ->info('Weather to use the sandbox environment for the SubmissionApi or the live environment')
                            ->example('false')
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->validate()
                ->ifTrue(static function (array $rootConfig) {
                    // The SubmissionApi client requires a WebApi client for validation.
                    if (isset($rootConfig['submission_api_client'])) {
                        return !isset($rootConfig['web_api_client']);
                    }

                    return false;
                })
                ->thenInvalid('The SubmissionApi client requires a WebApi client for validation.')
            ->end()
        ;

        return $treeBuilder;
    }
}
