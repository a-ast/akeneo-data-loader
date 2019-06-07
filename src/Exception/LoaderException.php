<?php

namespace Aa\AkeneoDataLoader\Exception;

use Exception;

class LoaderException extends Exception
{
    /**
     * @var array
     */
    private $errors;

    /**
     * @var string
     */
    private $connectorAlias;

    public function __construct(string $message, string $connectorAlias, array $errors)
    {
        $this->connectorAlias = $connectorAlias;
        $this->errors = $errors;

        parent::__construct($message);
    }

    public function getConnectorAlias(): string
    {
        return $this->connectorAlias;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
