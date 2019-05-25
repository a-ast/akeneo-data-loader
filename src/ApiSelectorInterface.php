<?php

namespace Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;

interface ApiSelectorInterface
{
    public function select(string $apiAlias): Uploadable;
}
