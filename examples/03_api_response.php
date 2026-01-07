<?php

use Aphonix\Result\Err;
use Aphonix\Result\Ok;

require_once __DIR__ . '/../vendor/autoload.php';

function fetch_from_main_api(): Err
{
    return Err("Main API is down (500)");
}

function fetch_from_backup_cache(): Ok
{
    return Ok(["data" => "cached results"]);
}

// Example: Error recovery with or_else
$data = fetch_from_main_api()
    ->map_err(function ($e) {
        error_log("LOG: " . $e); // Log the error
        return "System Busy";
    })
    ->or_else(function ($original_err) {
        echo "Attempting recovery via backup..." . PHP_EOL;
        return fetch_from_backup_cache();
    })
    ->unwrap();

print_r($data);