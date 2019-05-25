<?php

namespace Aa\AkeneoDataLoader\Upsert;

interface Upsertable
{
    public function upsert(array $data): iterable;
}
