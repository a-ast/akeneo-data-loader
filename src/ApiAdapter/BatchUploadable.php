<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\Response\ResponseBag;

interface BatchUploadable
{
    public function upload(array $data): ResponseBag;

    public function getBatchGroup(): string;
}
