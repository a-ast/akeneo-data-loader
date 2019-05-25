<?php

namespace Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Response\ResponseValidator;

class Loader
{
    /**
     * @var ApiSelector
     */
    private $apiSelector;

    /**
     * @var ResponseValidator
     */
    private $validator;

    public function __construct(ApiSelector $apiSelector, ResponseValidator $validator)
    {
        $this->apiSelector = $apiSelector;
        $this->validator = $validator;
    }

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\LoaderValidationException
     */
    public function load(string $apiAlias, iterable $dataProvider)
    {
        $api = $this->apiSelector->select($apiAlias);

        $response = $api->upload($dataProvider);

        $this->validator->validate($response);
    }
}
