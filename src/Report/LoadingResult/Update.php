<?php

namespace Aa\AkeneoDataLoader\Report\LoadingResult;

class Update implements LoadingResultInterface
{
    /**
     * @var string
     */
    private $dataIdentifier;

    public function __construct(string $dataCode)
    {
        $this->dataIdentifier = $dataCode;
    }

    public function getDataIdentifier(): string
    {
        return $this->dataIdentifier;
    }
}
