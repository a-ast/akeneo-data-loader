<?php

namespace Aa\AkeneoDataLoader\Connector;

interface BatchUploadable
{
    /**
     * @throws \Aa\AkeneoDataLoader\Exception\ConnectorException
     */
    public function upload(array $data);

    public function getBatchGroup(): string;
}
