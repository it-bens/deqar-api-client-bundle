<?php

declare(strict_types=1);

namespace ITB\DeqarApiClientBundle;

use ITB\DeqarApiClientBundle\DependencyInjection\Compiler\PublicForTestsCompilerPass;
use ITB\DeqarApiClientBundle\DependencyInjection\ITBDeqarApiClientExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class ITBDeqarApiClientBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new PublicForTestsCompilerPass());
    }

    /**
     * Overridden to allow for the custom extension alias.
     */
    public function getContainerExtension(): ITBDeqarApiClientExtension
    {
        if (null === $this->extension) {
            $this->extension = new ITBDeqarApiClientExtension();
        }

        return $this->extension;
    }
}
