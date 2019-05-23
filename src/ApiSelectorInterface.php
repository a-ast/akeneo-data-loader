<?php

namespace Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Upsert\Upsertable;

interface ApiSelectorInterface
{
    public function select(string $apiAlias): Upsertable;
}
