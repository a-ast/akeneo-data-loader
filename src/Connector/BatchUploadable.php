<?php

namespace Aa\AkeneoDataLoader\Connector;

use Traversable;

interface BatchUploadable
{
    /**
     * @return Traversable|\Aa\AkeneoDataLoader\Report\LoadingResult\LoadingResultInterface[]
     */
    public function upload(array $data): Traversable;

    public function getBatchGroup(): string;
}
