<?php

use Rewake\BitArray\BitArray;

require_once 'vendor/autoload.php';


$selectedOptions = [0, 63, 64, 1337];


$options = new BitArray();
$options->parse($selectedOptions);

//echo $options->binary(), PHP_EOL;
//echo $options->int(), PHP_EOL;
echo var_export($options->keys(), true), PHP_EOL;
//echo var_export($options->toArray(), true), PHP_EOL;
