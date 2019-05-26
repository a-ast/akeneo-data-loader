<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

interface Uploadable
{
    public function upload(iterable $data): iterable;
}
