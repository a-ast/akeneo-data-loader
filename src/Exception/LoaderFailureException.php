<?php

namespace Aa\AkeneoDataLoader\Exception;

use Aa\AkeneoDataLoader\Report\LoadingResult\Failure;
use Throwable;

class LoaderFailureException extends LoaderException
{
    /**
     * @var Failure
     */
    private $failure;

    public function __construct(string $message, Failure $failure, Throwable $previous = null)
    {
        $this->failure = $failure;

        parent::__construct($message, 0, $previous);
    }

    public function getFailure(): Failure
    {
        return $this->failure;
    }
}
