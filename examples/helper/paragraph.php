<?php

declare(strict_types=1);

function outputParagraph(string $format, ...$parameters): void
{
    if (count($parameters) === 0) {
        echo $format . PHP_EOL . PHP_EOL;

        return;
    }

    echo sprintf($format, ...$parameters) . PHP_EOL . PHP_EOL;
}
