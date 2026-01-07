<?php

use Aphonix\Result\Result;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * A simple function to parse JSON strings.
 */
function parse_json(string $json): Result
{
    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return Err("Invalid JSON: " . json_last_error_msg());
    }
    return Ok($data);
}

// Case 1: Success
$success = parse_json('{"name": "aphonix"}');
echo "Success case: " . $success->unwrap()['name'] . PHP_EOL;

// Case 2: Failure
$failure = parse_json('{invalid_json}');
if ($failure->is_err()) {
    echo "Failure case: " . $failure->unwrap_err() . PHP_EOL;
}