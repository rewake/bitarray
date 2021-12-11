<?php

namespace Rewake\BitArray;

class BitArray
{
    public const BIT_LENGTH = PHP_INT_SIZE * 8;

    private array $container = [0];
    private int $data = 0;

    public function parse(array $keys): BitArray
    {
        foreach ($keys as $key) {
            $this->set($key);
        }
        return $this;
    }

    public function set(int $bit): void
    {
        $this->locate($bit)->data |= (1 << $this->offset($bit));
    }

    public function unset(int $bit): void
    {
        $this->locate($bit)->data = ~(1 << $this->offset($bit));
    }

    public function enabled(int $bit): bool
    {
        return (1 << $this->offset($bit)) & $this->locate($bit)->data;
    }

    protected function row(int $bit): int
    {
        return intdiv($bit, self::BIT_LENGTH);
    }

    // TODO: research: SplFixedArray, Vector
    protected function locate(int $bit): BitArray
    {
        // Get row index
        $row = $this->row($bit);

        // Create new row if not already set
        $this->container[$row] ??= 0;

        // Store reference to container row
        $this->data =& $this->container[$row];

        // Return self
        return $this;
    }

    /**
     * Get offset of specified bit
     *
     * @param int $bit
     * @return int
     */
    protected function offset(int $bit): int
    {
        return $bit - ($this->row($bit) * self::BIT_LENGTH);
    }

    /**
     * Get key indexes for all set bits
     *
     * @return array
     */
    public function keys(): array
    {
        $keys = [];
        foreach ($this->container as $row) {
            $key = 0;
            do {
                ! ($row & 1) ?: $keys[] = $key;
                if ($row == -1) break;
                $key++;
            } while ($row >>= 1);
        }
        return $keys;
    }

    public function fillContainer()
    {
        $max = max(array_keys($this->container));
        $current = 0;
        while ($current < $max) {
            $this->container[$current] ??= 0;
            $current++;
        }
    }

    // TODO: work on formatting / output
    public function toArray(): array
    {
        $this->fillContainer();
        return $this->container;
    }

    public function int(): int
    {
        return $this->data;
    }

    public function binary(): string
    {
        return decbin($this->data);
    }

    public function hex(): string
    {
        return dechex($this->data);
    }
}
