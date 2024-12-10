<?php

require_once dirname(__FILE__) . "/../Input.php";
//require_once dirname(__FILE__) . "/../Map.php";

function search($data, $x, $y, $height, $part)
{
    global $peaks;

    static $sx, $sy;

    if ($height == 0) {
        $sx = $x; $sy = $y;
    }

    $sum = 0;

    if ($x < 0 || $x >= count($data[0]) || $y < 0 || $y >= count($data)) {
        return 0;
    }

    if ($data[$y][$x] != $height) {
        return 0;
    }

    if ($height == 9) {
        if ($part == 1 && in_array([$x, $y], $peaks[$sx][$sy] ?? [])) {
            return 0;
        } else {
            $peaks[$sx][$sy][] = [$x, $y];
            return 1;
        }
    }

    $sum += search($data, $x + 1, $y, $height + 1, $part);
    $sum += search($data, $x - 1, $y, $height + 1, $part);
    $sum += search($data, $x, $y + 1, $height + 1, $part);
    $sum += search($data, $x, $y - 1, $height + 1, $part);

    return $sum;
}

// ---

$data = Input::map(str_replace('.php', '.example.txt', __FILE__));
$data = Input::map(str_replace('.php', '.input.txt', __FILE__));

$peaks = [];

$sum1 = 0;
$sum2 = 0;

for ($y = 0; $y < count($data); $y++) {
    for ($x = 0; $x < count($data[0]); $x++) {
        $sum1 += search($data, $x, $y, 0, 1);
        $sum2 += search($data, $x, $y, 0, 2);
    }
}

echo "step 1: $sum1\n";
echo "step 2: $sum2\n";

