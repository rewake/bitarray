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
        $this->assertEquals([], $bitArray->toArray());
    }

    public function test_set_first_bit()
    {
        $bitArray = new BitArray();
        $bitArray->set(0);
        $this->assertEquals([0], $bitArray->toArray());
    }

    public function test_set_second_bit()
    {
        $bitArray = new BitArray();
        $bitArray->set(1);
        $this->assertEquals([1], $bitArray->toArray());
    }

    public function test_set_last_bit_in_length()
    {
        $bitArray = new BitArray();
        $maxBit = BitArray::BIT_LENGTH - 1;
        $bitArray->set($maxBit);
        $this->assertEquals([$maxBit], $bitArray->toArray());
    }

    public function test_cant_set_bit_above_length()
    {
        $bitArray = new BitArray();
        $maxBit = BitArray::BIT_LENGTH;
        $bitArray->set($maxBit);
        $this->assertNotEquals([$maxBit], $bitArray->toArray());
    }

    public function test_set_random_bit()
    {
        $bitArray = new BitArray();
        $rand = rand(0, BitArray::BIT_LENGTH - 1);
        $bitArray->set($rand);
        $this->assertEquals([$rand], $bitArray->toArray());
    }

    public function test_set_all_bits_sequentially()
    {
        $bitArray = new BitArray();
        $bit = 0;
        while ($bit < BitArray::BIT_LENGTH) {

            $bitArray->set($bit);
            echo decbin($bit), '-', decbin($bitArray->toArray()[0]), PHP_EOL;
//            $this->assertEquals([$bit], $bitArray->toArray());
            $bit++;
        }
    }
}
