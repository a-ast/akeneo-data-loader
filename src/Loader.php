<?php

namespace Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Api\RegistryInterface;
use Aa\AkeneoDataLoader\ApiAdapter\BatchUploadable;
use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Aa\AkeneoDataLoader\Batch\BatchGenerator;
use Aa\AkeneoDataLoader\Batch\ChannelingBatchGenerator;
use Aa\AkeneoDataLoader\Response\ResponseValidator;

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
     * @var int
     */
    private $upsertBatchSize;

    public function __construct(RegistryInterface $apiRegistry, ResponseValidator $validator, int $upsertBatchSize = 100)
    {
        $this->apiRegistry = $apiRegistry;
        $this->validator = $validator;
        $this->upsertBatchSize = $upsertBatchSize;
    }

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\LoaderValidationException
     * @throws \Aa\AkeneoDataLoader\Exception\UnknownDataTypeException
     */
    public function load(string $apiAlias, iterable $dataProvider)
    {
        $api = $this->apiRegistry->get($apiAlias);

        if ($api instanceof BatchUploadable) {

            $group = $api->getBatchGroup();
            $batchGenerator = $this->getBatchGenerator($group);

            foreach ($batchGenerator->getBatches($dataProvider) as $batch) {

                $response = $api->upload($batch);

                $this->validator->validate($response);
            }
        }

        if ($api instanceof Uploadable) {
            foreach ($dataProvider as $item) {
                $response = $api->upload($item);

                $this->validator->validate($response);
            }
        }

    }

    private function getBatchGenerator(string $group)
    {
        if ('' === $group) {
            return new BatchGenerator($this->upsertBatchSize);
        }

        return new ChannelingBatchGenerator($this->upsertBatchSize, $group);
    }
}
