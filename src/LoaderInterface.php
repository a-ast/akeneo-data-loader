<?php

namespace Aa\AkeneoDataLoader;

interface LoaderInterface
{
    /**
     * @throws \Aa\AkeneoDataLoader\Exception\LoaderValidationException
     * @throws \Aa\AkeneoDataLoader\Exception\UnknownDataTypeException
     */
    public function load(string $apiAlias, iterable $dataProvider);
}
