<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\Response\ResponseBag;

interface Uploadable
{
    public function upload(array $data): ResponseBag;
}
