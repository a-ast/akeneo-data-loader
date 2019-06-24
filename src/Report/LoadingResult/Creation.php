<?php

namespace Aa\AkeneoDataLoader\Report\LoadingResult;

class Creation implements LoadingResultInterface
{
    /**
     * @var string
     */
    private $dataIdentifier;

    public function __construct(string $dataIdentifier)
    {
        $this->dataIdentifier = $dataIdentifier;
    }

    public function getDataIdentifier(): string
    {
        return $this->dataIdentifier;
    }
}
