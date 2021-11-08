<?php

declare(strict_types=1);

namespace ITB\DeqarApiClientBundle\Tests\Mock;

use Symfony\Component\Serializer\SerializerInterface;

final class SerializerMock implements SerializerInterface
{
    /** @phpstan-ignore-next-line */
    public function serialize($data, string $format, array $context = [])
    {
    }

    /** @phpstan-ignore-next-line */
    public function deserialize($data, string $type, string $format, array $context = [])
    {
    }
}
