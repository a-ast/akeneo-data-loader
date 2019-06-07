<?php

namespace Aa\AkeneoDataLoader;

interface LoaderInterface
{
    /**
     * @throws \Aa\AkeneoDataLoader\Exception\ConnectorException
     * @throws \Aa\AkeneoDataLoader\Exception\UnknownDataTypeException
     */
    public function load(string $alias, iterable $dataProvider);
}
