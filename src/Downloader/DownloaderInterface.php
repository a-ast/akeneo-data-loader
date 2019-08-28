<?php

namespace Aa\AkeneoDataLoader\Downloader;

use Traversable;

interface DownloaderInterface
{
    public function download(string $dataType, array $filters): Traversable;
}
