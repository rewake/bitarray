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
        $this->locate($bit)->data =~ (1 << $this->offset($bit));
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





    public function keys(): array
    {
        $keys = [];

        for ($bit = 0; $bit < $this->length(); $bit++) {
            if ($this->enabled($bit)) {
                array_push($keys, $bit);
            }
        }

        return $keys;
    }

    public function enabled(int $bit): bool
    {
//        echo $this->offset($bit);
//        echo PHP_EOL;
//        var_dump( $this->locate($bit));
//        echo PHP_EOL;

        echo "----", PHP_EOL;
        return (1 << $this->offset($bit)) & $this->locate($bit)->data;
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
        var_dump($this->container);
        return decbin($this->data);
    }

    public function hex(): string
    {
        return dechex($this->data);
    }
}
