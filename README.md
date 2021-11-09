# The DEQAR API Client(s) Bundle

![Maintenance Status](https://img.shields.io/badge/Maintained%3F-yes-green.svg)
![CI Status](https://github.com/it-bens/deqar-api-client-bundle/actions/workflows/ci.yaml/badge.svg?branch=master)
[![codecov](https://codecov.io/gh/it-bens/deqar-api-client-bundle/branch/master/graph/badge.svg?token=B39XLZT3DL)](https://codecov.io/gh/it-bens/deqar-api-client-bundle)

## How to install the bundle?
The package can be installed via Composer:
```bash
composer require it-bens/it-bens/deqar-api-client-bundle
```
If you're using Symfony Flex, the bundle will be automatically enabled. For older apps, enable it in your Kernel class.

## How to use the DEQAR API Client(s) Bundle?
With this bundle, an `SubmissionApiClientInterface` and an `WebApiClientInterface` implementation is configured for auto-wiring.
Both clients have to be configured via symfony configuration:
```yaml
itb_deqar_api_client:
  web_api_client:
    deqar_username: '%env(string:DEQAR_API_USERNAME)%'
    deqar_password: '%env(string:DEQAR_API_PASSWORD)%'
    cache: 'itb_deqar_api_client.test_cache'
  submission_api_client:
    deqar_username: '%env(string:DEQAR_API_USERNAME)%'
    deqar_password: '%env(string:DEQAR_API_PASSWORD)%'
    test: true
```

The WebApiClient can be used without the SubmissionApi Client, but it's not possible to use the SubmissionApi client
without the WebApi client. The latter one requires WebApi access to check the provided agencies, activities and institutions.

If no `cache` key is provided, the uncached WebApi client will be used (also for the SubmissionApi client).
The cached WebApi client requires a valid and registered cache pool, provided with its id.

The usage of the clients is described here: [GitHub - DEQAR API Client(s)](https://github.com/it-bens/deqar-api-client).

## Contributing
I am really happy that the software developer community loves Open Source, like I do! ♥

That's why I appreciate every issue that is opened (preferably constructive)
and every pull request that provides other or even better code to this package.

You are all breathtaking!

## Special Thanks
This project is financed by the European Quality Assurance Register (EQAR) and the European Union, which I am very thankful for!