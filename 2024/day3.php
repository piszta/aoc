<?php

$rows = file(str_replace('.php', '.input.txt', __FILE__));

$sum1 = 0;
$sum2 = 0;

$enabled = true;

foreach ($rows as $row) {
    preg_match_all('/mul\((\d{1,3}),(\d{1,3})\)|do\(\)|don\'t\(\)/', $row, $matches);

    for ($i = 0; $i < count($matches[0]); $i++) {
        switch ($matches[0][$i]) {
            case 'do()':
                $enabled = true;
                break;

            case 'don\'t()':
                $enabled = false;
                break;

            default:
                $sum1 += $matches[1][$i] * $matches[2][$i];

                if ($enabled) {
                    $sum2 += $matches[1][$i] * $matches[2][$i];
                }

                break;
        }
    }
}

echo "step 1: $sum1\n";
echo "step 2: $sum2\n";
