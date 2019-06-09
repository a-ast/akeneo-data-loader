<?php

namespace Aa\AkeneoDataLoader\Report\LoadingResult;

class Update implements LoadingResultInterface
{
    /**
     * @var string
     */
    private $dataCode;

    public function __construct(string $dataCode)
    {
        $this->dataCode = $dataCode;
    }

    public function getDataCode(): string
    {
        return $this->dataCode;
    }
}
