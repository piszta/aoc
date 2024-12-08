<?php

require_once dirname(__FILE__) . "/../Input.php";
//require_once dirname(__FILE__) . "/../Map.php";

function setNodes(&$rows, $coord1, $coord2, $step = 1)
{
    $sum = 0;

    $dx = $coord2[0] - $coord1[0];
    $dy = $coord2[1] - $coord1[1];

    if ($step == 1) {
        $x = $coord2[0];
        $y = $coord2[1];
    } else {
        $x = $coord1[0];
        $y = $coord1[1];
    }

    while (true) {
        $x += $dx;
        $y += $dy;

        $m = $rows[$y][$x] ?? null;

        if ($m === null) {
            break;
        }

        if ($m != '#') {
            $rows[$y][$x] = '#';
            $sum++;
        }

        if ($step == 1) {
            break;
        }
    }

    return $sum;
}

// ---

$data = Input::map(str_replace('.php', '.example.txt', __FILE__));
$data = Input::map(str_replace('.php', '.input.txt', __FILE__));

$antennas = [];

$sum1 = 0;
$sum2 = 0;

$map1 = $map2 = $data;

foreach ($map1 as $y => $row) {
    foreach ($row as $x => $c) {
        if ($c != '.') {
            $antennas[$c][] = [$x, $y];
        }
    }
}

foreach ($antennas as $a => $coords) {
    for ($i = 0; $i < count($coords); $i++) {
        for ($j = $i + 1; $j < count($coords); $j++) {
            $sum1 += setNodes($map1, $coords[$i], $coords[$j], 1);
            $sum1 += setNodes($map1, $coords[$j], $coords[$i], 1);

            $sum2 += setNodes($map2, $coords[$i], $coords[$j], 2);
            $sum2 += setNodes($map2, $coords[$j], $coords[$i], 2);
        }
    }
}

echo "step 1: $sum1\n";
echo "step 2: $sum2\n";

