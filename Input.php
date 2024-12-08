<?php

class Input
{
    public static function text(string $filename): string
    {
        return trim(file_get_contents($filename));
    }

    public static function lines(string $filename): array
    {
        return file($filename, FILE_IGNORE_NEW_LINES);
    }

    public static function map(string $filename): array
    {
        $map = [];

        $lines = self::lines($filename);

        foreach ($lines as $line) {
            $map[] = str_split($line);
        }

        return $map;
    }
}
