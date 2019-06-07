<?php

namespace Aa\AkeneoDataLoader\Connector;

interface RegistryInterface
{
    public function register(string $alias, ConnectorInterface $api);

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\UnknownDataTypeException
     */
    public function get(string $alias): ConnectorInterface;
}
