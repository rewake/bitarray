<?php


class BitArray
{
    public const BIT_LENGTH = PHP_INT_SIZE * 8;

    private $bitArray = [];

    public function parse(array $keys): int
    {
        foreach ($keys as $key) {
            $this->set($key);
        }

        return $this->data;
    }

    public function locate(int $bit): int
    {
        return intdiv($bit, self::BIT_LENGTH);
    }

    public function data($bit)
    {
        return $this->bitArray[$this->locate($bit)];
    }

    public function set(int $bit): void
    {
        $this->data($bit) |= (1 << $bit);
    }

    public function uset(int $bit): void
    {
        $this->data &= ~(1 << $bit);
    }

    public function length(): int
    {
        return strlen(decbin($this->data));
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
        return (1 << $bit) & $this->data;
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


    // bitlength & chiunking
    public function lut()
    {

        return strlen(decbin(~0));
    }
}