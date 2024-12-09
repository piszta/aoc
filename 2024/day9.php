<?php

require_once dirname(__FILE__) . "/../Input.php";
//require_once dirname(__FILE__) . "/../Map.php";

function part1($raw)
{
    $from = count($raw) - 1;

    while (true) {
        //sleep(1);
        //echo "$raw\n";

        //$raw = rtrim($raw, '.');
        $x = array_search('.', $raw);

        for (; $from >= 0; $from--) {
            if ($raw[$from] != '.') {
                break;
            }
        }

        if ($x >= $from) {
            break;
        }

        $raw[$x] = $raw[$from];
        $raw[$from] = '.';
    }

    return $raw;
}

// ---

$data = Input::text(str_replace('.php', '.example.txt', __FILE__));
//$data = Input::text(str_replace('.php', '.input.txt', __FILE__));

$sum1 = 0;
$sum2 = 0;

$raw = [];
$id = 0;

for ($x = 0; $x < strlen($data); $x++) {
    $raw = array_merge($raw, array_fill(0, $data[$x], $x % 2 ? '.' : $id++));
}

$raw = part1($raw);

for ($x = 1; $x < count($raw); $x++) {
    $sum1 += $x * (int) $raw[$x];
}

echo "step 1: $sum1\n";
echo "step 2: $sum2\n";

