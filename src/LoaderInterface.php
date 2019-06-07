<?php

namespace Aa\AkeneoDataLoader;

interface LoaderInterface
{
    /**
     * @throws \Aa\AkeneoDataLoader\Exception\LoaderException
     */
    public function load(string $alias, iterable $dataProvider);
}
