<?php

namespace Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Api\LoadingResult\Factory;
use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Aa\AkeneoDataLoader\Connector\Uploadable;
use Aa\AkeneoDataLoader\Report\LoadingResult\LoadingResultInterface;
use Akeneo\PimEnterprise\ApiClient\Api\AssetVariationFileApiInterface;

class AssetVariationFile implements ConnectorInterface, Uploadable
{
    /**
     * @var AssetVariationFileApiInterface
     */
    private $api;

    /**
     * @var string
     */
    private $uploadDir;

    public function __construct(AssetVariationFileApiInterface $api, string $uploadDir)
    {
        $this->api = $api;
        $this->uploadDir = $uploadDir;
    }

    public function upload(array $data): LoadingResultInterface
    {
        $statusCode = $this->uploadData($data);

        return Factory::createFromStatusCode($statusCode, $data['path'] ?? '');
    }

    private function uploadData(array $data): int
    {
        // @todo: add trailing slash to mediaFilePath if missing
        $path = $this->uploadDir.$data['path'];
        $assetCode = $data['asset'];
        $channel = $data['channel'];

        if (isset($data['locale'])) {
            return $this->api->uploadForLocalizableAsset($path, $assetCode, $channel, $data['locale']);
        }

        return $this->api->uploadForNotLocalizableAsset($path, $assetCode, $channel);
    }
}
