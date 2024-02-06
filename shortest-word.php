<?php
function shortestWord($sentence) {
    // Split the sentence into words based on the space
    $words = explode(" ", $sentence);

    // Set the first word as the shortest word
    $shortestWord = $words[0];

    // Loop through the words and find the shortest word
    foreach ($words as $word) {
        if (strlen($word) < strlen($shortestWord)) {
            $shortestWord = $word;
        }
    }
    return $shortestWord;
}

$testCaseOne = "TRUE FRIENDS ARE ME AND YOU";
$testCaseTwo = "I AM THE LEGENDARY VILLAIN";

echo shortestWord($testCaseOne);
echo "\n";
echo shortestWord($testCaseTwo);
