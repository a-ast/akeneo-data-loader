<?php

namespace Aa\AkeneoDataLoader\Iterator;

use Iterator;

class BatchIterator implements Iterator
{

    /**
     * @var iterable
     */
    private $data;

    /**
     * @var int
     */
    private $batchSize;

    /**
     * @var array
     */
    private $currentBatch;

    private $index;

    /**
     */
    public function __construct(iterable $data, int $batchSize)
    {
        $this->data = $data;
        $this->batchSize = $batchSize;

        $this->currentBatch = [];
    }


    /**
     * Return the current element
     *
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->currentBatch;
    }

    /**
     * Move forward to next element
     *
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->currentBatch = [];
        $this->index = 0;

        foreach ($this->data as $item) {
            $this->currentBatch[] = $item;

            if ($this->batchSize === count($this->currentBatch)) {
                yield;

                $this->index++;
            }
        }
    }

    /**
     * Return the key of the current element
     *
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * Checks if current position is valid
     *
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return true;
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
    }
}
