<?php

namespace Aa\AkeneoDataLoader\Downloader;

use Aa\AkeneoDataLoader\Connector\Configuration;
use Aa\AkeneoDataLoader\Connector\Downloadable;
use Aa\AkeneoDataLoader\Connector\RegistryInterface;
use Traversable;

class Downloader implements DownloaderInterface
{

    /**
     * @var \Aa\AkeneoDataLoader\Connector\RegistryInterface
     */
    private $apiRegistry;

    /**
     * @var \Aa\AkeneoDataLoader\Connector\Configuration
     */
    private $configuration;

    public function __construct(RegistryInterface $apiRegistry, Configuration $configuration)
    {
        $this->apiRegistry = $apiRegistry;
        $this->configuration = $configuration;
    }

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\UnknownDataTypeException
     */
    public function download(string $dataType, array $filters): Traversable
    {
        $connector = $this->apiRegistry->get($dataType);

        if ($connector instanceof Downloadable) {
            return $connector->download($filters);
        }
    }
}
