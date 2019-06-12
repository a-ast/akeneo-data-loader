<?php

namespace Aa\AkeneoDataLoader\Api\Connector\Media;

class MediaExtractor
{
    const MEDIA_FILE_PREFIX = '@file:';

    /**
     * @return array|\Aa\AkeneoDataLoader\Api\Connector\Media\MediaData[]
     */
    public function extract(array $data): array
    {
        $media = [];

        foreach ($data as $product) {
            foreach ($product['values'] ?? [] as $attributeCode => $productValues) {
                foreach ($productValues as $productValue) {

                    if (false === isset($productValue['data']) ||
                        false === $this->isFile($productValue['data'])) {
                        continue;
                    }

                    $path = $this->getPathFromAttributeValue($productValue['data']);

                    $media[] = MediaData::create($path,
                        isset($product['identifier']),
                        $product['identifier'] ?? $product['code'],
                        $attributeCode,
                        $productValue['scope'],
                        $productValue['locale']
                    );
                }
            }
        }

        return $media;
    }

    public function removeMediaAttributes(array &$data)
    {
        foreach ($data as &$product) {
            foreach ($product['values'] ?? [] as $attributeCode => $productValues) {
                foreach ($productValues as $index => $productValue) {

                    if (false === isset($productValue['data']) ||
                        true === is_array($productValue['data'])) {
                        continue;
                    }

                    if ($this->isFile($productValue['data'])) {
                        unset($product['values'][$attributeCode][$index]);
                    }
                }

                if (0 === count($product['values'][$attributeCode])) {
                    unset($product['values'][$attributeCode]);
                }
            }
        }
    }

    private function isFile(string $attributeValue): bool
    {
        return strpos(trim($attributeValue), self::MEDIA_FILE_PREFIX) === 0;
    }

    private function getPathFromAttributeValue(string $attributeValue): string
    {
        return str_replace(self::MEDIA_FILE_PREFIX, '', $attributeValue);
    }
}
