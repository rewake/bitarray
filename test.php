<?php

use Rewake\BitArray\BitArray;

require_once 'vendor/autoload.php';


$selectedOptions = [33, 17, 10, 12, 24];


$options = new BitArray();
$options->parse($selectedOptions);

echo $options->binary(), PHP_EOL;
echo $options->int(), PHP_EOL;
echo var_export($options->keys(), true), PHP_EOL;
echo var_export($options->toArray(), true), PHP_EOL;
