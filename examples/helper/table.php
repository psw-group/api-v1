<?php

declare(strict_types=1);

function outputTable(array $list, $padTypes = []): void
{
    if (count($list) === 0) {
        return;
    }

    $index = 1;

    foreach ($list as $key => $row) {
        $list[$key] = array_merge(['#' => (string) $index], $row);
        $index++;
    }

    $padTypes['#'] = STR_PAD_LEFT;

    $lengths = [];

    foreach (array_keys($list[0]) as $column) {
        $lengths[$column] = maxLength($list, $column);
    }

    $isFirst = true;

    foreach ($list as $row) {
        if ($isFirst) {
            $isFirst = false;

            foreach (array_keys($row) as $column) {
                echo '| ' . pad($column, $lengths[$column], ' ', $padTypes[$column] ?? STR_PAD_RIGHT) . ' ';
            }
            echo '|' . PHP_EOL;
        }

        foreach ($row as $column => $data) {
            echo '| ' . pad($data, $lengths[$column], ' ', $padTypes[$column] ?? STR_PAD_RIGHT) . ' ';
        }
        echo '|' . PHP_EOL;
    }
}

function maxLength(array $list, string $column): int
{
    $max = mb_strlen($column, 'UTF-8');

    foreach ($list as $row) {
        $length = mb_strlen((string) $row[$column], 'UTF-8');

        if ($length > $max) {
            $max = $length;
        }
    }

    return $max;
}

function pad(string $input, int $pad_length, string $pad_string = ' ', int $pad_type = STR_PAD_RIGHT): string
{
    $mb_diff = strlen($input) - mb_strlen($input, 'UTF-8');

    return str_pad($input, $pad_length + $mb_diff, $pad_string, $pad_type);
}
