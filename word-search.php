<?php

function wordSearch($words, $target) {
    $indexes = [];

    // Loop through the words and find the target word
    for ($i = 0; $i < count($words); $i++) {
        // Check if the target word is in the current word
        if (strpos($words[$i], $target) !== false) {
            $indexes[] = $i;
        }
    }
    return $indexes;
}

$testCaseOne = ["I","TWO","FORTY","THREE",'JEN',"TWO","tWo","Two"];

print_r(wordSearch($testCaseOne, "TWO")); // [1,5]
