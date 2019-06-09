<?php

namespace Aa\AkeneoDataLoader\Connector;

use Aa\AkeneoDataLoader\Report\LoadingResult\LoadingResultInterface;

interface Uploadable
{
    public function upload(array $data): LoadingResultInterface;
}
