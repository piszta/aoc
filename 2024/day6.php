<?php

const DIRECTIONS = [
    [0, -1],
    [1, 0],
    [0, 1],
    [-1, 0],
];

function map($rows)
{
    foreach ($rows as $yy => $row) {
        echo "$row\n";
    }
    echo "\n";
}

function search2($origRows, $x, $y, $dir, $ox, $oy, $moves)
{
    if (!in_array([$ox, $oy], $moves)) {
        //var_dump([$ox, $oy]);
        return false;
    }

    if ($x == $ox && $y == $oy) {
        return false;
    }

    if (($origRows[$oy][$ox] ?? null) == '#') {
        return false;
    }

    $rows = $origRows;
    $rows[$oy][$ox] = 'O';

    $moves = [];
    $moved = false;

    while ($next = $rows[$y + DIRECTIONS[$dir][1]][$x + DIRECTIONS[$dir][0]] ?? null) {
        //usleep(500000);

        $moves[] = [$x, $y, $dir];
        $current = $rows[$y][$x];

        if (in_array($current, ['|', '-']) && $current != ($dir % 2 ? '-' : '|')) {
            $rows[$y][$x] = '+';
        } elseif (!in_array($current, ['^', '+'])) {
            $rows[$y][$x] = $dir % 2 ? '-' : '|';
        }

        //map($rows);

        if ($next == '#' || $next == 'O') {
            $dir = ($dir + 1) % 4;
            $moved = false;
            continue;
        }

        $x += DIRECTIONS[$dir][0];
        $y += DIRECTIONS[$dir][1];

        if (in_array([$x, $y, $dir], $moves)) {
            map($rows);
            return true;
        }

        $moves[] = [$x, $y, $dir];

        $moved = true;
    }

    return false;
}

function search3($origRows, $sx, $sy, $sdir = 0, $ox = null, $oy = null)
{
    global $obstacles;

    $rows = $origRows;
    $x = $sx; $y = $sy; $dir = $sdir;

    if ($ox && $oy) {
        $step = 2;
        $rows[$oy][$ox] = 'O';
    } else {
        $step = 1;
    }

    $moves = [];

    $sum1 = 1;
    $sum2 = 0;

    while (true) {
        //usleep(500000);
        //map($rows);

        if (in_array([$x, $y, $dir], $moves)) {
            //map($rows);
            return false;
        }

        $moves[] = [$x, $y, $dir];

        $current = $rows[$y][$x];

        if (in_array($current, ['|', '-']) && $current != ($dir % 2 ? '-' : '|')) {
            $rows[$y][$x] = '+';
        } elseif (!in_array($current, ['^', '+'])) {
            $sum1++;
            $rows[$y][$x] = $dir % 2 ? '-' : '|';
        }

        $next = $rows[$y + DIRECTIONS[$dir][1]][$x + DIRECTIONS[$dir][0]] ?? null;

        if ($next === null) {
            break;
        }

        if ($next == '#' || $next == 'O') {
            $dir = ($dir + 1) % 4;
            continue;
        }

        $lx = $x; $ly = $y;

        $x += DIRECTIONS[$dir][0];
        $y += DIRECTIONS[$dir][1];

        if ($step == 1 /*&& $next != '^'*/ && !isset($obstacles["{$x}_{$y}"])) {
            if (search3($rows, $lx, $ly, ($dir + 1) % 4, $x, $y) === false) {
                $obstacles["{$x}_{$y}"] = true;
                $sum2++;
            }
        }
    }

    return [$sum1, $sum2];
}

// ---

$rows = file(str_replace('.php', '.example.txt', __FILE__), FILE_IGNORE_NEW_LINES);
//$rows = file(str_replace('.php', '.input.txt', __FILE__), FILE_IGNORE_NEW_LINES);

foreach ($rows as $sy => $row) {
    if (($sx = strpos($row, '^')) !== false) {
        break;
    }
}

/*
echo "\nversion 2:\n";

$sum2 = 0;

foreach ($rows as $oy => $row) {
    for ($ox = 0; $ox < strlen($row); $ox++) {
        $r = search2($rows, $sx, $sy, 0, $ox, $oy, $moves);
        $sum2 += (int) $r;
    }
}

echo "step 2: $sum2\n";
*/

echo "\nversion 3:\n";

$obstacles = [];

[$sum1, $sum2] = search3($rows, $sx, $sy, 0);

echo "obstacles: " . count($obstacles) . "\n";
echo "step 1: $sum1\n";
echo "step 2: $sum2\n";
