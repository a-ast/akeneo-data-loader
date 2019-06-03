<?php

namespace Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Api\ApiSelector;
use Aa\AkeneoDataLoader\ApiAdapter\BatchUploadable;
use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Aa\AkeneoDataLoader\Batch\BatchGenerator;
use Aa\AkeneoDataLoader\Batch\ChannelingBatchGenerator;
use Aa\AkeneoDataLoader\Response\ResponseValidator;

class Loader implements LoaderInterface
{
    /**
     * @var ApiSelector
     */
    private $apiSelector;

    /**
     * @var ResponseValidator
     */
    private $validator;

    /**
     * @var int
     */
    private $upsertBatchSize;

    public function __construct(ApiSelector $apiSelector, ResponseValidator $validator, int $upsertBatchSize = 100)
    {
        $this->apiSelector = $apiSelector;
        $this->validator = $validator;
        $this->upsertBatchSize = $upsertBatchSize;
    }

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\LoaderValidationException
     */
    public function load(string $apiAlias, iterable $dataProvider)
    {
        $api = $this->apiSelector->select($apiAlias);

        if ($api instanceof Uploadable) {
            foreach ($dataProvider as $item) {
                $response = $api->upload($item);

                $this->validator->validate($response);
            }
        }

        if ($api instanceof BatchUploadable) {

            $group = $api->getBatchGroup();
            $batchGenerator = $this->getBatchGenerator($group);

            foreach ($batchGenerator->getBatches($dataProvider) as $batch) {

                $response = $api->upload($batch);

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
