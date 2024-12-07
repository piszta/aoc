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

function search($origRows, $x, $y, $dir, $step)
{
    static $obstacles = [];

    $rows = $origRows;

    $moves = [];
    $moves[] = [$x, $y, $dir];

    if ($step == 2) {
        if (in_array([$x + DIRECTIONS[$dir][0], $y + DIRECTIONS[$dir][1]], $obstacles)) {
            return true;
        }

        $obstacles[] = [$x + DIRECTIONS[$dir][0], $y + DIRECTIONS[$dir][1]];

        $rows[$y + DIRECTIONS[$dir][1]][$x + DIRECTIONS[$dir][0]] = 'O';
        $dir = ($dir + 1) % 4;
    }

    $sum1 = 2;
    $sum2 = 0;

    $moved = false;

    while ($next = $rows[$y + DIRECTIONS[$dir][1]][$x + DIRECTIONS[$dir][0]] ?? null) {
        $moves[] = [$x, $y, $dir];
        $current = $rows[$y][$x];

        if (in_array($current, ['|', '-']) && $current != ($dir % 2 ? '-' : '|')) {
            $rows[$y][$x] = '+';
        } elseif (!in_array($current, ['^', '+'])) {
            $sum1++;
            $rows[$y][$x] = $dir % 2 ? '-' : '|';
        }

        if ($next == '#' || $next == 'O') {
            $dir = ($dir + 1) % 4;
            $moved = false;
            continue;
        }

        if ($step == 1) {
            if (!search($rows, $x, $y, $dir, 2)) {
                $sum2++;
                echo "\nsum 2: $sum2\n";
            }
        }

        $x += DIRECTIONS[$dir][0];
        $y += DIRECTIONS[$dir][1];

        if (in_array([$x, $y, $dir], $moves)) {
            map($rows);
            return false;
        }

        $moved = true;
    }

    return [$sum1, $sum2];
}

function search2($origRows, $x, $y, $dir, $ox, $oy)
{
    if (abs($x - $ox) <= 1 && abs($y - $oy) <= 1) {
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
            //map($rows);
            return true;
        }

        $moved = true;
    }

    return false;
}

function search3($origRows, $x, $y, $dir, $step)
{
    $rows = $origRows;

    $moves = [];
    $moves[] = [$x, $y, $dir];

    if ($step == 2) {
        if (in_array([$x + DIRECTIONS[$dir][0], $y + DIRECTIONS[$dir][1]], $obstacles)) {
            return true;
        }

        $obstacles[] = [$x + DIRECTIONS[$dir][0], $y + DIRECTIONS[$dir][1]];

        $rows[$y + DIRECTIONS[$dir][1]][$x + DIRECTIONS[$dir][0]] = 'O';
        $dir = ($dir + 1) % 4;
    }

    $sum1 = 2;
    $sum2 = 0;

    $moved = false;

    while ($next = $rows[$y + DIRECTIONS[$dir][1]][$x + DIRECTIONS[$dir][0]] ?? null) {
        $moves[] = [$x, $y, $dir];
        $current = $rows[$y][$x];

        if (in_array($current, ['|', '-']) && $current != ($dir % 2 ? '-' : '|')) {
            $rows[$y][$x] = '+';
        } elseif (!in_array($current, ['^', '+'])) {
            $sum1++;
            $rows[$y][$x] = $dir % 2 ? '-' : '|';
        }

        if ($next == '#' || $next == 'O') {
            $dir = ($dir + 1) % 4;
            $moved = false;
            continue;
        }

        if ($step == 1) {
            if (!search($rows, $x, $y, $dir, 2)) {
                $sum2++;
                echo "\nsum 2: $sum2\n";
            }
        }

        $x += DIRECTIONS[$dir][0];
        $y += DIRECTIONS[$dir][1];

        if (in_array([$x, $y, $dir], $moves)) {
            map($rows);
            return false;
        }

        $moved = true;
    }

    return [$sum1, $sum2];
}

// ---

$rows = file(str_replace('.php', '.example.txt', __FILE__), FILE_IGNORE_NEW_LINES);
$rows = file(str_replace('.php', '.input.txt', __FILE__), FILE_IGNORE_NEW_LINES);

foreach ($rows as $sy => $row) {
    if (($sx = strpos($row, '^')) !== false) {
        break;
    }
}

/*
[$sum1, $sum2] = search($rows, $x, $y, 0, 1);

echo "step 1: $sum1\n";
echo "step 2: $sum2\n";
*/

echo "new step 2:\n";

$sum2 = 0;

foreach ($rows as $oy => $row) {
    for ($ox = 0; $ox < strlen($row); $ox++) {
        $r = search2($rows, $sx, $sy, 0, $ox, $oy);
        $sum2 += (int) $r;
        if ($r) {
            echo "sum: $sum2, $ox, $oy\n";
        }
    }
}

echo "step 2: $sum2\n";

