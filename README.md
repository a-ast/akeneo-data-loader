# Akeneo Data Loader

[![Build Status](https://travis-ci.org/a-ast/akeneo-data-loader.svg?branch=master)](https://travis-ci.org/a-ast/akeneo-data-loader)

Akeneo Data Loader helps you to load data to your Akeneo PIM via its REST API. 


## Use cases

* Load YAML fixtures for testing, local development or for performance benchmarking.
* Import product data from external systems (legacy PIM or regular data providers). 

## Features

* Support for bulk data upload (upsert mode).
* Simplified import of media files.

### Examples

#### Load from an array

```php
use Aa\AkeneoDataLoader\Api;
use Aa\AkeneoDataLoader\LoaderFactory;

$factory = new LoaderFactory();

$apiCredentials = Api\Credentials::create('https://your.akeneo.host/', 'clientId', 'secret', 'username', 'password');

$loader = $factory->createByCredentials($apiCredentials);

$loader->load('product', [
    [
        'identifier' => 'test-product',
        'enabled'    => true,
        'family'     => 'accessories',
        'categories' => [
            'master_accessories',
            'print_accessories',
            'suppliers',
        ],
        'values' => [
            'ean'    => [[ 'locale' =>  null, 'scope' =>  null, 'data' => '1234567890183' ]],
            'name'   => [[ 'locale' =>  null, 'scope' =>  null, 'data' => 'Test product' ]],
            'image'  => [[ 'locale' =>  null, 'scope' =>  null, 'data' => '@file:asset/1111111171.jpg' ]],
            'weight' => [[ 'locale' =>  null, 'scope' =>  null, 'data' => [ 'amount' =>  '500.0000', 'unit' => 'GRAM' ] ]],
        ],
    ],
]);
```
* Check [how to load media files](#LoadMediaFiles) if you wonder what does `@file:` mean.

#### Load from a YAML file

```php
use Aa\AkeneoDataLoader\Api;
use Aa\AkeneoDataLoader\LoaderFactory;
use Symfony\Component\Yaml\Yaml;

$factory = new LoaderFactory();
$apiCredentials = Api\Credentials::create('https://your.akeneo.host/', 'clientId', 'secret', 'username', 'password');
$loader = $factory->createByCredentials($apiCredentials);

$productData = Yaml::parse(file_get_contents('data/product.yaml'));

$loader->load('product', $productData);
```
* [Examples of YAML files](doc/yaml-format.md)


## How to load data using data loader

As you can see, to load data you need to know:

1. Your Akeneo host and API credentials
2. Data type
3. Data format 

### 1. Akeneo host and API credentials

I hope you know your Akeneo host, so use it by creating a `Credentials` object.

Besides this, you need to know the name and password of the user that you going to use for connecting via API.

Last, but not the least, you need the client ID and secret of an API connection.  
You can create a connection in you Akeneo in the `System > API connection` section or 
use the console command to generate it:

```
bin/console pim:oauth-server:create-client Import
```  

### 2. Data type

Data loader supports the following data types:

* channel
* category
* attribute-group
* attribute
* attribute-option
* family
* family-variant
* product-model
* product

and also these Enterprise Edition data types:

* asset
* asset-variation-file
* asset-reference-file
* reference-entity
* reference-entity-record

### 3. Data format 

The data format is a [format of Akeneo REST API](https://api.akeneo.com/documentation/resources.html).

Check also [Examples of YAML files](doc/yaml-format.md) that represent the data format. 

## <a id="LoadMediaFiles"></a>How to load media files

You can simply upload a file and assign it as a value of image or file attributes.

```php
$loader->load('product', [
    'values' => [
        'image'  => [
            [ 
                'locale' => 'en_US', 
                'scope'  => 'ecommerce', 
                'data'   => '@file:relative/path/to/your/asset.jpg' 
            ],
        ],
    ],
]);

```

The prefix `@file:` tells Akeneo Data Loader to read this media file `relative/path/to/your/asset.jpg` 
and assign it as the value of the attribute `image`.

You can specify the base directory path for media files using configuration of LoaderFactory:  

```php
use Aa\AkeneoDataLoader\LoaderFactory;
use Aa\AkeneoDataLoader\Connector\Configuration;

$configuration = Configurationcreate('assets/baseDir/path');
$factory = new LoaderFactory($configuration);
```

## How to query and modify data

You can use Data loader to modify data fetched using Akeneo API.

```php
use Aa\AkeneoDataLoader\Api;
use Aa\AkeneoDataLoader\LoaderFactory;
use Akeneo\Pim\ApiClient\AkeneoPimClientBuilder;
use Akeneo\Pim\ApiClient\Search\SearchBuilder;

// Fetch data using Akeneo UPI

$clientBuilder = new AkeneoPimClientBuilder('https://your.akeneo.host/');
$client = $clientBuilder->buildAuthenticatedByPassword('clientId', 'secret', 'admin', 'admin');

$searchBuilder = new SearchBuilder();
$searchBuilder->addFilter('price', 'EMPTY');
$searchFilters = $searchBuilder->getFilters();

$products = $client->getProductApi()->all(100, ['search' => $searchFilters]);

// Send modified data back

$factory = new LoaderFactory();

$apiCredentials = Api\Credentials::create(
    'https://your.akeneo.host/',
    'clientId', 'secret', 'admin', 'admin');

$loader = $factory->createByCredentials($apiCredentials);

foreach ($products as $product) {
    $product['enabled'] = false;
    $loader->load('product', [$product]);
}
``` 
