<?php

namespace Aa\AkeneoDataLoader;

interface LoaderInterface
{
    /**
     * @throws \Aa\AkeneoDataLoader\Exception\LoaderFailureException
     */
    public function load(string $dataType, iterable $dataProvider);
}
