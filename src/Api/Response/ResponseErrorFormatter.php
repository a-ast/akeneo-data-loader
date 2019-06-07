<?php

namespace Aa\AkeneoDataLoader\Api\Response;

class ResponseErrorFormatter
{
    public function format(array $response): string
    {
        $output = [
            sprintf('Field "%s": %s', $response['code'] ?? '', $response['message'] ?? ''),
            sprintf('Status code: %d', $response['status_code'])
        ];

        if (isset($response['errors'])) {
            $output[] = 'Errors:';

            foreach ($response['errors'] as $error) {
                $output[] = sprintf('    - %s: %s',$error['property'] ?? '',$error['message'] ?? '');
            }
        }

        return implode(PHP_EOL, $output);
    }
}
