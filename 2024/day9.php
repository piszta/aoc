<?php

require_once dirname(__FILE__) . "/../Input.php";
//require_once dirname(__FILE__) . "/../Map.php";

function checksum($raw)
{
    $sum = 0;

    for ($x = 1; $x < count($raw); $x++) {
        $sum += $x * (int) $raw[$x];
    }

    return $sum;
}

function part1($raw)
{
    $from = count($raw) - 1;

    while (true) {
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

    return checksum($raw);
}

function part2($raw)
{
    $from = count($raw) - 1;

    while (true) {
        [$from, $len, $number] = searchDataBlock($raw, $from);
        $to = searchEmptyBlock($raw, $len);

        if ($from < 0) {
            break;
        }

        if ($to == false || $from < $to) {
            continue;
        }

        copyData($raw, $from + 1, $to, $len, $number);
    }

    return checksum($raw);
}

function searchDataBlock($raw, $from)
{
    $len = false;
    $number = false;

    for (; $from >= 0; $from--) {
        if (($number = $raw[$from]) == '.') {
            continue;
        }

        $f = $from;

        for (; $from >= 0; $from--) {
            if ($raw[$from] != $number) {
                $len = $f - $from;
                break 2;
            }
        }
    }

    return [$from, $len, $number];
}

function searchEmptyBlock($raw, $len)
{
    for ($to = 0; $to < count($raw); $to++) {
        $number = $raw[$to];

        if ($number != '.') {
            continue;
        }

        for ($i = 0; $i < $len; $i++) {
            if ($to + $i >= count($raw)) {
                break 2;
            }

            if ($raw[$to + $i] != '.') {
                continue 2;
            }
        }

        return $to;
    }

    return false;
}

function copyData(&$raw, $from, $to, $len, $number)
{
    for ($i = 0; $i < $len; $i++) {
        $raw[$to + $i] = $number;
        $raw[$from + $i] = '.';
    }
}

// ---

$data = Input::text(str_replace('.php', '.example.txt', __FILE__));
$data = Input::text(str_replace('.php', '.input.txt', __FILE__));

$sum1 = 0;
$sum2 = 0;

$raw = [];
$id = 0;

for ($x = 0; $x < strlen($data); $x++) {
    $raw = array_merge($raw, array_fill(0, $data[$x], $x % 2 ? '.' : $id++));
}

$sum1 = part1($raw);
$sum2 = part2($raw);

echo "step 1: $sum1\n";
echo "step 2: $sum2\n";

