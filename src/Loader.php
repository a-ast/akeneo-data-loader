<?php

namespace Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Api\Configuration;
use Aa\AkeneoDataLoader\Api\RegistryInterface;
use Aa\AkeneoDataLoader\ApiAdapter\ConnectorInterface;
use Aa\AkeneoDataLoader\ApiAdapter\BatchUploadable;
use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Aa\AkeneoDataLoader\Batch\BatchGenerator;
use Aa\AkeneoDataLoader\Batch\ChannelingBatchGenerator;
use Aa\AkeneoDataLoader\Response\ResponseValidator;
use Traversable;

class Loader implements LoaderInterface
{
    /**
     * @var RegistryInterface
     */
    private $apiRegistry;

    /**
     * @var ResponseValidator
     */
    private $validator;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(RegistryInterface $apiRegistry, Configuration $configuration)
    {
        $this->apiRegistry = $apiRegistry;
        $this->configuration = $configuration;

        $this->validator = new ResponseValidator();
    }

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\LoaderValidationException
     * @throws \Aa\AkeneoDataLoader\Exception\UnknownDataTypeException
     */
    public function load(string $apiAlias, iterable $dataProvider)
    {
        $api = $this->apiRegistry->get($apiAlias);

        try {

            if ($api instanceof BatchUploadable) {

                $batches = $this->getDataBatches($dataProvider, $api->getBatchGroup());

                $this->uploadBatchesAndValidate($api, $batches);
            }

            if ($api instanceof Uploadable) {
                $this->uploadAndValidate($api, $dataProvider);
            }

        } catch (Exception\LoaderValidationException $e) {



        }
    }

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\LoaderValidationException
     */
    private function uploadAndValidate(Uploadable $api, iterable $dataProvider)
    {
        foreach ($dataProvider as $item) {
            $response = $api->upload($item);

            $this->validator->validate($response);
        }
    }

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\LoaderValidationException
     */
    private function uploadBatchesAndValidate(BatchUploadable $api, iterable $dataProvider)
    {
        foreach ($dataProvider as $batch) {
            $response = $api->upload($batch);

            $this->validator->validate($response);
        }
    }

    private function getDataBatches(iterable $dataProvider, string $group): Traversable
    {
        $batchGenerator = $this->getBatchGenerator($group);

        return $batchGenerator->getBatches($dataProvider);
    }

    private function getBatchGenerator(string $group)
    {
        $upsertBatchSize = $this->configuration->getUpsertBatchSize();

        if ('' === $group) {
            return new BatchGenerator($upsertBatchSize);
        }

        return new ChannelingBatchGenerator($upsertBatchSize, $group);
    }
}
