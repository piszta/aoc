<?php

function analyze(array $report): bool
{
    $oldDiff = null;
    $old = current($report);

    while ($new = next($report)) {
        $diff = $old - $new;

        if (abs($diff) < 1 || abs($diff) > 3) {
            return false;
        }

        if ($oldDiff !== null
            && $oldDiff !==0 && $diff !== 0
            && $oldDiff / abs($oldDiff) !== $diff / abs($diff)
        ) {
            return false;
        }

        $oldDiff = $diff;
        $old = $new;
    }

    return true;
}

// ---

$rows = file(str_replace('.php', '.input.txt', __FILE__));

$sum1 = 0;
$sum2 = 0;

foreach ($rows as $row) {
    $report = explode(' ', trim($row));

    if (analyze($report)) {
        $sum1++;
        $sum2++;

        continue;
    }

    for ($i = 0; $i < count($report); $i++) {
        $r = $report;
        unset($r[$i]);

        if (analyze($r)) {
            $sum2++;
            break;
        }
    }
}

echo "step 1: $sum1\n";
echo "step 2: $sum2\n";
