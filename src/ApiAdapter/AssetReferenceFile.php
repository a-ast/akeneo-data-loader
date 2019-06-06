<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\ApiAdapter\ApiAdapterInterface;
use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Aa\AkeneoDataLoader\Response\ResponseBag;
use Akeneo\PimEnterprise\ApiClient\Api\AssetReferenceFileApiInterface;

class AssetReferenceFile implements ApiAdapterInterface, Uploadable
{
    /**
     * @var AssetReferenceFileApiInterface
     */
    private $api;

    /**
     * @var string
     */
    private $uploadDir;

    public function __construct(AssetReferenceFileApiInterface $api, string $uploadDir)
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

        if (isset($data['locale'])) {
            return $this->api->uploadForLocalizableAsset($path, $assetCode, $data['locale']);
        }

        return $this->api->uploadForNotLocalizableAsset($path, $assetCode);
    }
}
