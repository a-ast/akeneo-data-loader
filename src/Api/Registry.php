<?php

namespace Aa\AkeneoDataLoader\Api;

use Aa\AkeneoDataLoader\ApiAdapter\ApiAdapterInterface;
use Aa\AkeneoDataLoader\Exception\UnknownDataTypeException;

class Registry
{
    /**
     * @var array|ApiAdapterInterface[]
     */
    private $items;

    public function register(string $alias, ApiAdapterInterface $api)
    {
        $this->items[$alias] = $api;
    }

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\UnknownDataTypeException
     */
    public function get(string $alias): ApiAdapterInterface
    {
        if (false === isset($this->items[$alias])) {
            throw new UnknownDataTypeException(sprintf('Unknown data type: %s', $alias));
        }

        return $this->items[$alias];
    }
}
