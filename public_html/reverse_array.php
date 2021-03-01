<?php
/**
 * @noinspection ForgottenDebugOutputInspection
 */

$array = [1, 5, 7, 9, 2, 4, 6, 8];
$arrayLastIndex = count($array) - 1;

$reversedArray = [];
for ($i = 0; $i <= $arrayLastIndex; $i++) {
    $reversedArray[ $i ] = $array[ $arrayLastIndex - $i ];
}

echo var_export($array)."<br>";             // 1, 5, 7, 9, 2, 4, 6, 8
echo var_export($reversedArray)."<br>";     // 8, 6, 4, 2, 9, 7, 5, 1
