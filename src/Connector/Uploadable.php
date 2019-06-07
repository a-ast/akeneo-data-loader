<?php

namespace Aa\AkeneoDataLoader\Connector;

interface Uploadable
{
    /**
     * @throws \Aa\AkeneoDataLoader\Exception\ConnectorException
     */
    public function upload(array $data);
}
