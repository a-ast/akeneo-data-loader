<?php

namespace Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Api\LoadingResult\Factory;
use Aa\AkeneoDataLoader\Connector\BatchUploadable;
use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Aa\AkeneoDataLoader\Report\LoadingResult\Failure;
use Akeneo\Pim\ApiClient\Api\MediaFileApiInterface;
use Akeneo\Pim\ApiClient\Api\Operation\UpsertableResourceListInterface;
use Akeneo\Pim\ApiClient\Exception\HttpException;
use Traversable;

class Product implements ConnectorInterface, BatchUploadable
{
    /**
     * @var UpsertableResourceListInterface
     */
    private $api;

    /**
     * @var MediaFileApiInterface
     */
    private $mediaFileApi;

    public function __construct(UpsertableResourceListInterface $api, MediaFileApiInterface $mediaFileApi)
    {
        $this->api = $api;
        $this->mediaFileApi = $mediaFileApi;
    }

    public function upload(array $data): Traversable
    {
        // @todo: iterate data - take file info and remove file attrs
        $responses = $this->api->upsertList($data);

//        $fileInfos = [];
//

//
//        foreach ($fileInfos as $path => $fileInfo) {
//
//            // $fileInfo[]
//
//            try {
//                $mediaFileCode = $this->mediaFileApi->create($path, $fileInfo);
//            } catch (\Exception $e) {
//
//                $statusCode = 0;
//
//                if ($e instanceof HttpException) {
//                    $statusCode = $e->getResponse()->getStatusCode();
//                }
//
//                // @todo: file cannot be read - check how implemented in the OLD Importer
//
//                // @todo: yield or accumulate
//                $failure = new Failure(
//                    $fileInfo['code'] ?? $fileInfo['identifier'],
//                    $e->getMessage(),
//                    $statusCode,
//                    0, // @todo: how to tackle real index ? store indexes separately?
//                    []
//                );
//            }
//
//        }

        // @todo: iterate all values, check if starts with "file:" or "path:"
        // call MediaFileApiInterface::create
        // fill all fields
        // catch InvalidArgumentException and HttpException
        // merge (how) 2 sources


        return Factory::createFromResponses($responses);
    }

    public function getBatchGroup(): string
    {
        return '';
    }
}
