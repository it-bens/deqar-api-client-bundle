<?php

declare(strict_types=1);

namespace ITB\DeqarApiClientBundle\Tests\Mock;

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ValidatorMock implements ValidatorInterface
{
    /** @phpstan-ignore-next-line */
    public function validate($value, $constraints = null, $groups = null): void
    {
    }

    /** @phpstan-ignore-next-line */
    public function validateProperty(object $object, string $propertyName, $groups = null)
    {
    }

    /** @phpstan-ignore-next-line */
    public function validatePropertyValue($objectOrClass, string $propertyName, $value, $groups = null)
    {
    }

    /** @phpstan-ignore-next-line */
    public function startContext()
    {
    }

    /** @phpstan-ignore-next-line */
    public function inContext(ExecutionContextInterface $context)
    {
    }

    /** @phpstan-ignore-next-line */
    public function getMetadataFor($value)
    {
    }

    /** @phpstan-ignore-next-line */
    public function hasMetadataFor($value)
    {
    }
}
