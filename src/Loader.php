<?php

namespace Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Connector\Configuration;
use Aa\AkeneoDataLoader\Connector\RegistryInterface;
use Aa\AkeneoDataLoader\Connector\BatchUploadable;
use Aa\AkeneoDataLoader\Connector\Uploadable;
use Aa\AkeneoDataLoader\Batch\BatchGenerator;
use Aa\AkeneoDataLoader\Batch\ChannelingBatchGenerator;
use Traversable;

class Loader implements LoaderInterface
{
    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(RegistryInterface $registry, Configuration $configuration)
    {
        $this->registry = $registry;
        $this->configuration = $configuration;
    }

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\ConnectorException
     * @throws \Aa\AkeneoDataLoader\Exception\UnknownDataTypeException
     */
    public function load(string $alias, iterable $dataProvider)
    {
        $connector = $this->registry->get($alias);

        try {

            if ($connector instanceof BatchUploadable) {

                $batches = $this->getDataBatches($dataProvider, $connector->getBatchGroup());

                $this->uploadBatchesAndValidate($connector, $batches);
            }

            if ($connector instanceof Uploadable) {
                $this->uploadAndValidate($connector, $dataProvider);
            }

        } catch (Exception\ConnectorException $e) {

            // @todo: implement wrapping to LoaderException

        }
    }

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\ConnectorException
     */
    private function uploadAndValidate(Uploadable $connector, iterable $dataProvider)
    {
        foreach ($dataProvider as $item) {
            $connector->upload($item);
        }
    }

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\ConnectorException
     */
    private function uploadBatchesAndValidate(BatchUploadable $connector, iterable $dataProvider)
    {
        foreach ($dataProvider as $batch) {
            $connector->upload($batch);
        }
    }

    private function getDataBatches(iterable $dataProvider, string $group): Traversable
    {
        $batchGenerator = $this->getBatchGenerator($group);

        return $batchGenerator->getBatches($dataProvider);
    }

    private function getBatchGenerator(string $group)
    {
        $batchSize = $this->configuration->getBatchSize();

        if ('' === $group) {
            return new BatchGenerator($batchSize);
        }

        return new ChannelingBatchGenerator($batchSize, $group);
    }
}
