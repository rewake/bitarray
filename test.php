<?php

require_once 'BitArray.php';

$items = [
    0 => 'xs',
//    1 => 's',
//    2 => 'm',
//    3 => 'l',
//    4 => 'xl',
//    62 => '2xl',
//    63 => '2xl',
//    64 => '2xl',
//    65 => '2xl',
    100 => '2xl',
];



$bitArray = new BitArray();
$bitArray->parse(array_keys($items));

echo $bitArray::BIT_LENGTH, PHP_EOL;

echo $bitArray->locate(128), PHP_EOL;

exit;

//$bitArray->uset(3);
//$bitArray->uset(5);


echo implode(',', $bitArray->keys()), PHP_EOL;

//$bitArray->set(24);

echo $bitArray->int(), PHP_EOL;
echo $bitArray->binary(), PHP_EOL;
echo $bitArray->hex(), PHP_EOL;

