<?php

namespace Aa\AkeneoDataLoader\Api\Connector\Media;

class MediaData
{
    /**
     * @var bool
     */
    private $isProduct;

    /**
     * @var string
     */
    private $dataCode;

    /**
     * @var string
     */
    private $attribute;

    /**
     * @var string
     */
    private $scope;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $path;

    private function __construct(string $path, bool $isProduct, string $dataCode,
        string $attribute, string $scope, string $locale)
    {
        $this->path = $path;
        $this->isProduct = $isProduct;
        $this->dataCode = $dataCode;
        $this->attribute = $attribute;
        $this->scope = $scope;
        $this->locale = $locale;
    }

    public static function create(string $path, bool $isProduct, string $dataCode,
        string $attribute, string $scope, string $locale)
    {
        return new static($path, $isProduct, $dataCode, $attribute, $scope, $locale);
    }

    public function toArray()
    {
        $dataCodeProperty = $this->isProduct ? 'identifier' : 'code';

        return [
            'type' => $this->isProduct ? 'product' : 'product_model',
            $dataCodeProperty => $this->dataCode,
            // @todo: code for model
            'attribute' => $this->attribute,
            'scope' => $this->scope,
            'locale' => $this->locale,
        ];
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getDataCode(): string
    {
        return $this->dataCode;
    }
}
