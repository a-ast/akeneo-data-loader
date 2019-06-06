<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\ApiAdapter\ApiAdapterInterface;
use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Aa\AkeneoDataLoader\Response\ResponseBag;
use Akeneo\PimEnterprise\ApiClient\Api\AssetVariationFileApiInterface;

class AssetVariationFile implements ApiAdapterInterface, Uploadable
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

    public function upload(array $data): ResponseBag
    {
        $statusCode = $this->uploadData($data);

        return ResponseBag::createByStatusCodeList([$statusCode]);
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
