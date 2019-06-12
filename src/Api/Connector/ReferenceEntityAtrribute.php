<?php

namespace Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Api\LoadingResult\Factory;
use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Aa\AkeneoDataLoader\Connector\Uploadable;
use Aa\AkeneoDataLoader\Report\LoadingResult\LoadingResultInterface;
use Akeneo\PimEnterprise\ApiClient\Api\ReferenceEntityAttributeApiInterface;

class ReferenceEntityAtrribute implements ConnectorInterface, Uploadable
{
    /**
     * @var ReferenceEntityAttributeApiInterface
     */
    private $api;

    public function __construct(ReferenceEntityAttributeApiInterface $api)
    {
        $this->api = $api;
    }

    /**
     * Upload a reference entity.
     *
     * Important: batch mode is not supported in Akeneo API.
     */
    public function upload(array $data): LoadingResultInterface
    {
        $referenceEntityCode = $data['reference_entity'];
        unset($data['reference_entity']);
        $code = $data['code'];

        $statusCode = $this->api->upsert($referenceEntityCode, $code, $data);

        return Factory::createFromStatusCode($statusCode, $referenceEntityCode);
    }
}
