<?php

namespace spec\Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Connector\Configuration;
use Aa\AkeneoDataLoader\Connector\RegistryInterface;
use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Aa\AkeneoDataLoader\Connector\BatchUploadable;
use Aa\AkeneoDataLoader\Connector\Uploadable;
use Aa\AkeneoDataLoader\Exception\LoaderFailureException;
use Aa\AkeneoDataLoader\Report\LoadingResult\Creation;
use Aa\AkeneoDataLoader\Report\LoadingResult\Failure;
use ArrayObject;
use PhpSpec\ObjectBehavior;
use Webmozart\Assert\Assert;

class LoaderSpec extends ObjectBehavior
{
    function let(RegistryInterface $apiRegistry, Configuration $configuration)
    {
        $configuration->getBatchSize()->willReturn(100);

        $this->beConstructedWith($apiRegistry, $configuration);
    }

    function it_loads_data_in_batch(RegistryInterface $apiRegistry, ConnectorInterface $api)
    {
        $data = [['a' => 1]];

        $apiRegistry->get('product')->willReturn($api);

        $api->implement(BatchUploadable::class);
        $api->getBatchGroup()->willReturn('');

        $api
            ->upload($data)
            ->willReturn(new ArrayObject(new Creation('1')))
            ->shouldBeCalled();

        $this->load('product', $data);
    }

    function it_returns_failure_with_correct_index_of_failed_data_item(
        RegistryInterface $apiRegistry,
        ConnectorInterface $api)
    {
        $data = [
            ['a' => 1],
            ['b' => 2],
            ['c' => 3],
        ];

        $apiRegistry->get('product')->willReturn($api);

        $api->implement(Uploadable::class);

        $api->upload(['a' => 1])->willReturn(new Creation('1'));
        $api->upload(['b' => 2])->willReturn(new Creation('2'));
        $api->upload(['c' => 3])->willReturn(new Failure('3', 'Error', 123, 0, []));

        try {
            $this->load('product', $data);
        } catch (LoaderFailureException $exception) {

            Assert::same('Error', $exception->getMessage());
            Assert::same(2,       $exception->getFailure()->getIndex());
            Assert::same('Error', $exception->getFailure()->getMessage());
            Assert::same('3',     $exception->getFailure()->getDataIdentifier());
            Assert::same(123,     $exception->getFailure()->getErrorCode());
            Assert::same([],            $exception->getFailure()->getErrors());
        }
    }
}
