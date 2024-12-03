<?php

require_once(dirname(__FILE__) . '/../Utils.php');

// ---

$rows = Utils::getInput(2024, 3);

$sum1 = 0;
$sum2 = 0;

$enabled = true;

foreach ($rows as $row) {
    preg_match_all('/mul\((\d{1,3}),(\d{1,3})\)|do\(\)|don\'t\(\)/', $row, $matches);

    for ($i = 0; $i < count($matches[0]); $i++) {
        switch (substr($matches[0][$i], 0, 3)) {
            case 'mul':
                $sum1 += $matches[1][$i] * $matches[2][$i];

                if ($enabled) {
                    $sum2 += $matches[1][$i] * $matches[2][$i];
                }

                break;

            case 'do(':
                $enabled = true;
                break;

            case 'don':
                $enabled = false;
                break;
        }
    }
}

echo "step 1: $sum1\n";
echo "step 2: $sum2\n";
