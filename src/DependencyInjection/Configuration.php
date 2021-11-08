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
                        ->end()
                        ->scalarNode('deqar_password')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('cache')
                            ->cannotBeEmpty()
                            ->defaultNull()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('submission_api_client')
                    ->children()
                        ->scalarNode('deqar_username')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('deqar_password')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->booleanNode('test')
                            ->defaultFalse()
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
