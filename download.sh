#!/bin/bash
cd "$(dirname "$0")"

if [ -n "$1" ]; then
    DAY=$(echo "$1" | sed 's/^0*//')
else
    DAY=$(date +%d | sed 's/^0*//')
fi

YEAR=$(date +%Y)
mkdir -p "$YEAR"
cd "$YEAR"

curl --cookie "session=$AOC_SESSION" https://adventofcode.com/$YEAR/day/$DAY/input > "day$DAY.input.txt"
