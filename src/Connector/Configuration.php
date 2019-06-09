<?php

namespace Aa\AkeneoDataLoader\Connector;

class Configuration
{
    /**
     * @var string
     */
    private $assetBaseDir;

    /**
     * @var int
     */
    private $batchSize;

    public function __construct(string $assetBaseDir, int $batchSize)
    {
        $this->assetBaseDir = $assetBaseDir;
        $this->batchSize = $batchSize;
    }

    public static function create(string $assetBaseDir, int $batchSize = 100)
    {
        return new static($assetBaseDir, $batchSize);
    }

    public function getAssetBaseDir(): string
    {
        return $this->assetBaseDir;
    }

    public function getBatchSize(): int
    {
        return $this->batchSize;
    }
}
