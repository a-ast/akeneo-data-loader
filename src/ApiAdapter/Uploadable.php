<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

interface Uploadable
{
    public function upload(array $data): iterable;
}
