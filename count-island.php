<?php

function generateOutput($matrix) {
    $output = '';

    for ($i = 0; $i < count($matrix); $i++) {
        for ($j = 0; $j < count($matrix[$i]); $j++) {
            if ($matrix[$i][$j] == 1) {
                $output .= 'X';
            } else {
                $output .= '~';
            }
        }

        $output .= PHP_EOL; // Move to the next line after each row
    }

    echo $output;
}

generateOutput([
    [1, 1, 1, 1],
    [0, 1, 1, 0],
    [0, 1, 0, 1],
    [1, 1, 0, 0]
]);
