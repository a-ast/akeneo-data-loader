<?php

namespace spec\Aa\AkeneoDataLoader\Api\Connector\Media;

use Aa\AkeneoDataLoader\Api\Connector\Media\MediaData;
use Aa\AkeneoDataLoader\Api\Connector\Media\MediaExtractor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Webmozart\Assert\Assert;

class MediaExtractorSpec extends ObjectBehavior
{
    function it_extract_media_data_from_product_data()
    {
        $productData = $this->getProductData();

        $this
            ->extract($productData)
            ->shouldBeLike([
                MediaData::create('path/image1.jpg', true, 'a', 'image1', 'ecommerce', 'en_GB'),
                MediaData::create('path/image2.jpg', true, 'b', 'image2', 'ecommerce', 'en_GB'),
                MediaData::create('path/image3.jpg', true, 'b', 'image2', 'ecommerce', 'de_DE'),
            ]);
    }

    function it_removes_media_attributes_with_file_prefix()
    {
        $productData = $this->getProductData();

        $this
            ->getWrappedObject()
            ->removeMediaAttributes($productData);

        Assert::same($productData, [
                [
                    'identifier' => 'a',
                    'values' => [
                        'name' => [
                            [
                                'data' => 'a',
                                'locale' => 'en_GB',
                                'scope' => null
                            ]
                        ],
                    ]
                ],
                [
                    'identifier' => 'b',
                    'values' => [
                        'name' => [
                            [
                                'data' => 'b',
                                'locale' => 'en_GB',
                                'scope' => null,
                            ]
                        ],
                    ],
                ],
            ]);
    }

    private function getProductData(): array
    {
        $productData = [
            [
                'identifier' => 'a',
                'values' => [
                    'name' => [
                        [
                            'data' => 'a',
                            'locale' => 'en_GB',
                            'scope' => null
                        ]
                    ],
                    'image1' => [
                        [
                            'data' => '@file:path/image1.jpg',
                            'locale' => 'en_GB',
                            'scope' => 'ecommerce'
                        ]
                    ],
                ]
            ],
            [
                'identifier' => 'b',
                'values' => [
                    'name' => [
                        [
                            'data' => 'b',
                            'locale' => 'en_GB',
                            'scope' => null,
                        ]
                    ],
                    'image2' => [
                        [
                            'data' => '@file:path/image2.jpg',
                            'locale' => 'en_GB',
                            'scope' => 'ecommerce'
                        ],
                        [
                            'data' => '@file:path/image3.jpg',
                            'locale' => 'de_DE',
                            'scope' => 'ecommerce'
                        ],
                    ],
                ],
            ],
        ];

        return $productData;
    }
}
