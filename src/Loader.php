<?php

namespace Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Connector\Configuration;
use Aa\AkeneoDataLoader\Connector\RegistryInterface;
use Aa\AkeneoDataLoader\Connector\BatchUploadable;
use Aa\AkeneoDataLoader\Connector\Uploadable;
use Aa\AkeneoDataLoader\Batch\BatchGenerator;
use Aa\AkeneoDataLoader\Batch\ChannelingBatchGenerator;
use Aa\AkeneoDataLoader\Exception\LoaderFailureException;
use Aa\AkeneoDataLoader\Report\LoadingResult\Failure;
use Aa\AkeneoDataLoader\Report\LoadingResult\LoadingResultInterface;
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
     * @throws \Aa\AkeneoDataLoader\Exception\LoaderException
     */
    public function load(string $dataType, iterable $dataProvider)
    {
        $connector = $this->registry->get($dataType);

        if ($connector instanceof BatchUploadable) {

            $batches = $this->getDataBatches($dataProvider, $connector->getBatchGroup());
            $this->uploadBatchesAndValidate($connector, $batches);
        }

        if ($connector instanceof Uploadable) {
            $this->uploadAndValidate($connector, $dataProvider);
        }
    }

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\LoaderFailureException
     */
    private function uploadAndValidate(Uploadable $connector, iterable $dataProvider)
    {
        foreach ($dataProvider as $item) {
            $result = $connector->upload($item);

            $this->processResult($result);
        }
    }

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\LoaderFailureException
     */
    private function uploadBatchesAndValidate(BatchUploadable $connector, iterable $dataProvider)
    {
        foreach ($dataProvider as $batch) {
            $results = $connector->upload($batch);

            foreach ($results as $result) {
                $this->processResult($result);
            }
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

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\LoaderFailureException
     */
    private function processResult(LoadingResultInterface $result)
    {
        if ($result instanceof Failure) {

            // @todo: recalculte current index from batch or current index
            throw new LoaderFailureException($result->getMessage(), $result);

        }

    }
}
