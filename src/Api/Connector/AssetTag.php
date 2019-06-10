<?php

namespace Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Api\LoadingResult\Factory;
use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Aa\AkeneoDataLoader\Connector\Uploadable;
use Aa\AkeneoDataLoader\Report\LoadingResult\LoadingResultInterface;
use Akeneo\PimEnterprise\ApiClient\Api\AssetTagApiInterface;

class AssetTag implements ConnectorInterface, Uploadable
{
    /**
     * @var AssetTagApiInterface
     */
    private $api;

    public function __construct(AssetTagApiInterface $api)
    {
        $this->api = $api;
    }

    /**
     * Upload an asset tag
     *
     * Important: batch mode is not supported by Akeneo API.
     */
    public function upload(array $data): LoadingResultInterface
    {
        $assetTagCode = $data['code'];
        $statusCode = $this->api->upsert($assetTagCode);

        return Factory::createFromStatusCode($statusCode, $assetTagCode);
    }
}
