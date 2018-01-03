<?php

require_once(__DIR__ . '/init.php');

$thread = new Thread();
$bannedWords = 'banana apple mongoose pear duck';

// Actual implementation below
$mostRecentThreads = $thread->getRecentThreads(3, true); 
$wordsToCheck = explode(" ", $bannedWords);
displayRecentThreads($mostRecentThreads);
replaceBannedWords($mostRecentThreads, $wordsToCheck);

 /**
 * @param array $mostRecentThreads
 * 
 */
function displayRecentThreads($mostRecentThreads) {
     echo json_encode($mostRecentThreads);
     echo "\n";
}

 /**
 * @param array $mostRecentThreads
 * @param array $wordsToCheck
 * 
 */
function replaceBannedWords($mostRecentThreads, $wordsToCheck) {
    foreach ($mostRecentThreads as $thread) {
        $thread["message"] = str_replace($wordsToCheck, "****", $thread["message"]);
        echo $thread["message"];
        echo "\n";
    }
}
