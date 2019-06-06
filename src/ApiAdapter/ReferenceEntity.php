<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\ApiAdapter\ApiAdapterInterface;
use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Aa\AkeneoDataLoader\Response\ResponseBag;
use Akeneo\PimEnterprise\ApiClient\Api\ReferenceEntityApiInterface;

class ReferenceEntity implements ApiAdapterInterface, Uploadable
{
    /**
     * @var ReferenceEntityApiInterface
     */
    private $api;

    public function __construct(ReferenceEntityApiInterface $api)
    {
        $this->api = $api;
    }

    /**
     * Upload a reference entity.
     *
     * Important: batch mode is not yet supported in Akeneo API.
     */
    public function upload(array $data): ResponseBag
    {
        $referenceEntityCode = $data['code'];
        $statusCode = $this->api->upsert($referenceEntityCode, $data);

        return ResponseBag::createByStatusCodeList([$statusCode]);
    }
}
