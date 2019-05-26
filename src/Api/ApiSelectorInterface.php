<?php

namespace Aa\AkeneoDataLoader\Api;

use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;

interface ApiSelectorInterface
{
    public function select(string $apiAlias): Uploadable;
}
