<?php

namespace Aa\AkeneoDataLoader\Api\Response;

class ResponseError
{
    /**
     * @var array
     */
    private $response;

    private function __construct(array $response)
    {
        $this->response = $response;
    }

    public static function createFromResponse(array $response)
    {
        return new static($response);
    }

    public function __toString(): string
    {
        $output = [
            sprintf('Field "%s": %s', $this->response['code'] ?? '', $this->response['message'] ?? ''),
            sprintf('Status code: %d', $this->response['status_code'])
        ];

        if (isset($this->response['errors'])) {
            $output[] = 'Errors:';

            foreach ($this->response['errors'] as $error) {
                $output[] = sprintf('    - %s: %s',$error['property'] ?? '',$error['message'] ?? '');
            }
        }

        return implode(PHP_EOL, $output);
    }
}
