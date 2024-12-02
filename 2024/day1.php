<?php

require_once(dirname(__FILE__) . '/../Utils.php');

function step1(array $list1, array $list2): void
{
    sort($list1);
    sort($list2);

    $distance = 0;

    for ($i = 0; $i < count($list1); $i++) {
        $distance += abs($list1[$i] - $list2[$i]);
    }

    echo "step 1: $distance\n";
}

function step2(array $list1, array $list2): void
{
    $counts = array_count_values($list2);
    $similarity = 0;

    foreach ($list1 as $value) {
        $similarity += $value * ($counts[$value] ?? 0);
    }

    echo "step 2: $similarity\n";
}

// ---

$input = Utils::getInput(2024, 1);

foreach ($input as $i => $row) {
    [$list1[], $list2[]] = explode('   ', trim($row));
}

step1($list1, $list2);
step2($list1, $list2);
