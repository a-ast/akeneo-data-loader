<?php

namespace Aa\AkeneoDataLoader\Api;

use Aa\AkeneoDataLoader\ApiAdapter\ApiAdapterInterface;

interface RegistryInterface
{
    public function register(string $alias, ApiAdapterInterface $api);

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\UnknownDataTypeException
     */
    public function get(string $alias): ApiAdapterInterface;
}
