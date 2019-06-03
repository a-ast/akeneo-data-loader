<?php

namespace Aa\AkeneoDataLoader\Api;

use Aa\AkeneoDataLoader\ApiAdapter\ApiAdapterInterface;

interface ApiSelectorInterface
{
    public function select(string $apiAlias): ApiAdapterInterface;
}
