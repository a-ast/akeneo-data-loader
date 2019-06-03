<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;


interface BatchUploadable
{
    public function upload(array $data): iterable;

    public function getBatchGroup(): string;
}
