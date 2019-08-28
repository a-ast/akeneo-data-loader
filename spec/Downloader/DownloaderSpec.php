<?php

namespace spec\Aa\AkeneoDataLoader\Downloader;

use Aa\AkeneoDataLoader\Connector\Configuration;
use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Aa\AkeneoDataLoader\Connector\Downloadable;
use Aa\AkeneoDataLoader\Connector\RegistryInterface;
use Aa\AkeneoDataLoader\Downloader\Downloader;
use Aa\AkeneoDataLoader\Downloader\DownloaderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DownloaderSpec extends ObjectBehavior
{
    function let(RegistryInterface $apiRegistry, Configuration $configuration)
    {
        $configuration->getBatchSize()->willReturn(100);

        $this->beConstructedWith($apiRegistry, $configuration);
    }

    function it_is_downloader()
    {
        $this->shouldHaveType(DownloaderInterface::class);
    }

    function it_downloads(RegistryInterface $apiRegistry, ConnectorInterface $connector)
    {
        $apiRegistry
            ->get('product')
            ->willReturn($connector)
            ->shouldBeCalled();

        $connector->implement(Downloadable::class);
        $connector->download([])->willReturn(new \ArrayObject());

        $this->download('product', [])->shouldHaveType(\Traversable::class);
    }
}
