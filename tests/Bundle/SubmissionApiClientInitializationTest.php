<?php

declare(strict_types=1);

namespace ITB\DeqarApiClientBundle\Bundle\Tests;

use ITB\DeqarApiClient\SubmissionApi\SubmissionApiClient;
use ITB\DeqarApiClient\SubmissionApi\SubmissionApiClientInterface;
use ITB\DeqarApiClient\SubmissionApi\Validation\ExistingActivityValidator;
use ITB\DeqarApiClient\SubmissionApi\Validation\ExistingAgencyValidator;
use ITB\DeqarApiClient\SubmissionApi\Validation\ExistingInstitutionValidator;
use ITB\DeqarApiClient\SubmissionApi\Validation\ValidActivityInstitutionProgrammeCombinationValidator;
use ITB\DeqarApiClient\SubmissionApi\Validation\WebFilePdfValidator;
use ITB\DeqarApiClientBundle\Tests\ITBDeqarApiClientBundleKernel;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

final class SubmissionApiClientInitializationTest extends TestCase
{
    /** @var ContainerInterface $container */
    private ContainerInterface $container;

    public function setUp(): void
    {
        $config = Yaml::parseFile(__DIR__ . '/../Fixtures/BundleConfiguration/submission_api_client_config.yaml');
        $kernel = new ITBDeqarApiClientBundleKernel('test', true, $config);
        $kernel->boot();
        $this->container = $kernel->getContainer();
    }

    public function testServiceWiring(): void
    {
        $submissionApiClient = $this->container->get('itb_deqar_api_client.submission_api_client');
        self::assertInstanceOf(SubmissionApiClient::class, $submissionApiClient);

        $existingActivityValidator = $this->container->get(ExistingActivityValidator::class);
        self::assertInstanceOf(ExistingActivityValidator::class, $existingActivityValidator);
        $existingAgencyValidator = $this->container->get(ExistingAgencyValidator::class);
        self::assertInstanceOf(ExistingAgencyValidator::class, $existingAgencyValidator);
        $existingInstitutionValidator = $this->container->get(ExistingInstitutionValidator::class);
        self::assertInstanceOf(ExistingInstitutionValidator::class, $existingInstitutionValidator);
        $validActivityInstitutionProgrammeCombinationValidator = $this->container->get(ValidActivityInstitutionProgrammeCombinationValidator::class);
        self::assertInstanceOf(ValidActivityInstitutionProgrammeCombinationValidator::class, $validActivityInstitutionProgrammeCombinationValidator);
        $webFilePdfValidator = $this->container->get(WebFilePdfValidator::class);
        self::assertInstanceOf(WebFilePdfValidator::class, $webFilePdfValidator);
    }

    public function testServiceAlias(): void
    {
        $submissionApiClient = $this->container->get(SubmissionApiClientInterface::class);
        self::assertInstanceOf(SubmissionApiClient::class, $submissionApiClient);
    }
}
