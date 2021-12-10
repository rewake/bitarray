<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use Rewake\BitArray\BitArray;

class BitArrayTest extends TestCase
{
    public function test_instantiate_bit_array()
    {
        $bitArray = new BitArray();
        $this->assertInstanceOf(BitArray::class, $bitArray);
    }

    public function test_no_bits_set_by_default()
    {
        $bitArray = new BitArray();
        $this->assertEquals([0], $bitArray->toArray());
    }

    public function test_set_zeroth_bit()
    {
        $bitArray = new BitArray();
        $bitArray->set(0);
        $this->assertEquals([bindec(1)], $bitArray->toArray());
    }
    public function test_set_second_bit()
    {
        $bitArray = new BitArray();
        $bitArray->set(1);
        $this->assertEquals([bindec(10)], $bitArray->toArray());
    }

    public function test_set_third_bit()
    {
        $bitArray = new BitArray();
        $bitArray->set(2);
        $this->assertEquals([bindec(100)], $bitArray->toArray());
    }

    public function test_set_last_bit_in_length()
    {
        $bitArray = new BitArray();
        $maxBit = BitArray::BIT_LENGTH - 1;
        $bitArray->set($maxBit);
        $this->assertEquals([1 << $maxBit], $bitArray->toArray());
    }

    public function test_cant_set_bit_above_length()
    {
        $bitArray = new BitArray();
        $maxBit = BitArray::BIT_LENGTH;
        $bitArray->set($maxBit);
        $this->assertNotEquals([1 << $maxBit], $bitArray->toArray());
    }

    public function test_set_random_bit()
    {
        $bitArray = new BitArray();
        $rand = rand(0, BitArray::BIT_LENGTH);
        $bitArray->set($rand);
        $this->assertEquals([1 << $rand], $bitArray->toArray());
    }

    public function test_set_all_bits_sequentially()
    {
        $bitArray = new BitArray();
        $bit = 0;
        $expected = 0;
        while ($bit < BitArray::BIT_LENGTH) {
            $bitArray->set($bit);
            $expected |= 1 << $bit;
            $this->assertEquals([$expected], $bitArray->toArray());
            $bit++;
        }
    }
}
