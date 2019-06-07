<?php

namespace Aa\AkeneoDataLoader\Exception;

use Exception;

class ConnectorException extends Exception
{
    /**
     * @var array
     */
    private $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;

        parent::__construct('Data loading failed.');
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
