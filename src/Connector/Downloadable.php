<?php

namespace Aa\AkeneoDataLoader\Connector;

use Traversable;

interface Downloadable
{
    public function download(array $filters): Traversable;
}
