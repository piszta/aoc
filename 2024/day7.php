<?php

function calc($total, array $numbers, $number = 0, $part)
{
    $result = 0;

    if (($n = array_shift($numbers)) === null) {
        return ($number == $total) ? $total : 0;
    }

    $result |= calc($total, $numbers, $number + $n, $part);
    $result |= calc($total, $numbers, $number * $n, $part);

    if ($part == 2) {
        $result |= calc($total, $numbers, "$number$n", $part);
    }

    return $result;
}

// ---

//$rows = file(str_replace('.php', '.example.txt', __FILE__), FILE_IGNORE_NEW_LINES);
$rows = file(str_replace('.php', '.input.txt', __FILE__), FILE_IGNORE_NEW_LINES);

$sum1 = 0;
$sum2 = 0;

foreach ($rows as $row) {
    [$total, $raw] = explode(':', trim($row));
    $numbers = array_map('intval', explode(' ', trim($raw)));

    $number = array_shift($numbers);
    $sum1 += calc($total, $numbers, $number, 1);
    $sum2 += calc($total, $numbers, $number, 2);
}

echo "step 1: $sum1\n";
echo "step 2: $sum2\n";

