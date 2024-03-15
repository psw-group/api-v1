# PSW GROUP API

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

Our API empowers customers to build amazing new apps or websites using PSW GROUP shop data and services. This SDK provides all the code necessary for the integration of our API into your projects.    

## Installation

If composer is not yet on your system, follow the instructions on [getcomposer.org](https://getcomposer.org) to do so.

To add the psw-group/api-v1 dependency to your project, simply run the following command from the root of your project:

``` bash
$ composer require psw-group/api-v1
```

## Requirements

You will need a recent version of PHP, at least PHP 8.1.

This package requires PSR-17 compatible request/URI factories and a PSR-18 compatible HTTP client.
If no factories are supplied, it uses [PHP-HTTP](https://php-http.org) discovery to find installed implementations.
 
For example if you want to use [Guzzle](http://guzzlephp.org) as HTTP client execute:

``` bash
$ composer require http-interop/http-factory-guzzle php-http/guzzle7-adapter
```
## Usage

Create a client for the environment (test or production) you want to use. Inject it into a repository. Repositories then allow you to load single resources or collections of resources and provide methods to execute operations on those resources.
``` php                                                                         
<?php

use PswGroup\Api\TestClient;
use PswGroup\Api\Repository\ProductRepository;

include 'vendor/autoload.php';

// Create a client for the test environment
$client = new TestClient(
    '[yourClientId]',
    '[yourClientSecret]'
);

// Load all available products
$productRepository = new ProductRepository($client);
$products = $productRepository->loadAll();

```

There are a number of files in the [examples](examples) folder, which show you how to get started quickly.

## Documentation

For more detailed information you can check the [docs](docs) folder.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/psw-group/api-v1.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/psw-group/api-v1.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/psw-group/api-v1
[link-downloads]: https://packagist.org/packages/psw-group/api-v1
[link-author]: https://github.com/psw-group
