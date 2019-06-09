<?php

namespace Aa\AkeneoDataLoader\Report\LoadingResult;

class Failure implements LoadingResultInterface
{
    /**
     * @var string
     */
    private $dataCode;

    /**
     * @var int
     */
    private $errorCode;

    /**
     * @var int
     */
    private $index;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var string
     */
    private $message;

    public function __construct(
        string $dataCode,
        string $message,
        int $errorCode,
        int $index,
        array $errors)
    {
        $this->message = $message;
        $this->dataCode = $dataCode;
        $this->errorCode = $errorCode;
        $this->index = $index;
        $this->errors = $errors;
    }

    public function getDataCode(): string
    {
        return $this->dataCode;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function __toString(): string
    {
        $output = [
            sprintf('Data code / identifier: %s', $this->getDataCode()),
            sprintf('Error code: %d', $this->getErrorCode())
        ];

        if (count($this->getErrors()) > 0) {
            $output = array_merge($output,
                ['Errors:'],
                $this->getErrors()
            );
        }

        return implode(PHP_EOL, $output);
    }
}
