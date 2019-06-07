<?php

namespace Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Aa\AkeneoDataLoader\Connector\Uploadable;
use Aa\AkeneoDataLoader\Api\Response\ResponseValidator;
use Akeneo\PimEnterprise\ApiClient\Api\ReferenceEntityApiInterface;

class ReferenceEntity implements ConnectorInterface, Uploadable
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
     *
     * @throws \Aa\AkeneoDataLoader\Exception\ConnectorException
     */
    public function upload(array $data)
    {
        $referenceEntityCode = $data['code'];
        $statusCode = $this->api->upsert($referenceEntityCode, $data);

        ResponseValidator::validateStatusCode($statusCode);
    }
}
