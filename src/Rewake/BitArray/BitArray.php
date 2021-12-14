<?php

namespace Rewake\BitArray;

class BitArray
{
    public const BIT_LENGTH = PHP_INT_SIZE * 8;

    // TODO: research SplFixedArray, Vector, etc. for container
    private array $container = [0];
    private int $data = 0;

    /**
     * Parses array of keys/indexes into a BitArray
     *
     * @param array $keys
     * @return BitArray
     */
    public function parse(array $keys): BitArray
    {
        foreach ($keys as $key) {
            $this->set($key);
        }
        return $this;
    }

    /**
     * Set the given bit (set to 1)
     *
     * @param int $bit
     */
    public function set(int $bit): void
    {
        $this->locate($bit)->data |= (1 << $this->offset($bit));
    }

    /**
     * Unset the given bit (set to 0)
     *
     * @param int $bit
     */
    public function unset(int $bit): void
    {
        $this->locate($bit)->data = ~(1 << $this->offset($bit));
    }

    /**
     * See if the given bit is enabled (is set to 1)
     *
     * @param int $bit
     * @return bool
     */
    public function enabled(int $bit): bool
    {
        return (1 << $this->offset($bit)) & $this->locate($bit)->data;
    }

    /**
     * Get row index of given bit
     *
     * @param int $bit
     * @return int
     */
    protected function row(int $bit): int
    {
        return intdiv($bit, self::BIT_LENGTH);
    }

    /**
     * Locates the given bit by determining & referencing its row
     *
     * @param int $bit
     * @return $this
     */
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
        $this->fillContainer();
        $keys = [];
        foreach ($this->container as $index => $row) {
            $key = 0;
            do {
                ! ($row & 1) ?: $keys[] = $key + ($index * self::BIT_LENGTH);
                if ($row == -1) break;
                $key++;
            } while ($row >>= 1);
        }
        return $keys;
    }

    /**
     * Fills the container rows up to max bits' row
     * Ex:  if only bit 64 is set (in row[1]), row[0] would not be
     *      created, so this method "fills" the empty container rows.
     *
     * @return void
     */
    public function fillContainer(): void
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
