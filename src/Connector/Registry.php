<?php

namespace Aa\AkeneoDataLoader\Connector;

use Aa\AkeneoDataLoader\Exception\UnknownDataTypeException;

class Registry implements RegistryInterface
{
    /**
     * @var array|ConnectorInterface[]
     */
    private $items;

    public function register(string $alias, ConnectorInterface $api): RegistryInterface
    {
        $this->items[$alias] = $api;

        return $this;
    }

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\UnknownDataTypeException
     */
    public function get(string $alias): ConnectorInterface
    {
        if (false === isset($this->items[$alias])) {
            throw new UnknownDataTypeException(sprintf('Unknown data type: %s', $alias));
        }

        return $this->items[$alias];
    }
}
