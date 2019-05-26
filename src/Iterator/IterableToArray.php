<?php

namespace Aa\AkeneoDataLoader\Iterator;

class IterableToArray
{
    public static function convert(iterable $iterator): array
    {
        if ($iterator instanceof \Traversable) {
            return iterator_to_array($iterator);
        }

        if (is_array($iterator)) {
            return $iterator;
        }
    }
}
