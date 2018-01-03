<?php

require_once(__DIR__ . '/init.php');
header('Content-Type: application/json');
if ($argc != 3) {
    throw new Exception('Invalid number of arguments provided');
}

$title = $argv[1];
$message = $argv[2];

echo validateThread($title, $message);

 /**
 * @param string $title
 * @param string $message
 * 
 * @return json message
 */
function validateThread($title, $message) {
    if (strlen($title) < 3) {
        return json_encode(formatErrorResponse(432,  "title field is too short"));
    } if (strlen($message) < 3) {
        return json_encode(formatErrorResponse(432,  "message field is too short"));
    } if (strlen($title) > 32) {
        return json_encode(formatErrorResponse(432,  "title field is too long"));
    } if (strlen($message) > 52) {
        return json_encode(formatErrorResponse(432,  "message field is too long"));
    } else {
        $thread = new Thread();
        $thread->newThread($title, $message, true, time());
        return json_encode(array("status" => 200));
    }
}

 /**
 * @param int $status
 * @param string $errorMsg
 * 
 * @return array
 */
function formatErrorResponse($status, $errorMsg) {
    return array(
        "status" => $status,
        "error" => $errorMsg
    );
}
