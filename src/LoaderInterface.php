<?php

namespace Aa\AkeneoDataLoader;

interface LoaderInterface
{
    /**
     * @throws \Aa\AkeneoDataLoader\Exception\LoaderValidationException
     */
    public function load(string $apiAlias, iterable $dataProvider);
}
