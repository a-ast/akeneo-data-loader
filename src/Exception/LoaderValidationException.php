<?php

namespace Aa\AkeneoDataLoader\Exception;

use Exception;

class LoaderValidationException extends Exception
{
    /**
     * @var array
     */
    private $validationErrors;

    public function __construct(array $validationErrors)
    {
        $this->validationErrors = $validationErrors;

        parent::__construct('Data loading failed.');
    }

    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }
}
