<?php

use Aphonix\Result\Ok;
use Aphonix\Result\Result;

require_once __DIR__ . '/../vendor/autoload.php';

// Mocking some business logic
function find_user($id)
{
    return $id === 1 ? Ok(['id' => 1, 'name' => 'Alice']) : Err("User not found");
}

function check_permission($user)
{
    return $user['name'] === 'Alice' ? Ok($user) : Err("Permission denied");
}

function get_account_balance($user): Ok
{
    return Ok(5000); // Assume balance is 5000
}

// --- The Rust Style Chain ---
$user_id = 1;

$result = find_user($user_id)
    ->and_then('check_permission')
    ->and_then('get_account_balance')
    ->map(function ($balance) {
        return $balance . " USD";
    });

// Handle the final result
$output = match_result($result);
echo "Final Result: " . $output . PHP_EOL;

/**
 * A helper to simulate pattern matching
 */
function match_result(Result $res): string
{
    if ($res->is_ok()) {
        return "Success! Balance is " . $res->unwrap();
    }
    return "Failed! Reason: " . $res->unwrap_err();
}