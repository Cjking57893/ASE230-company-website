<?php

function readJsonFile($fileName): mixed {
    // Check if file exists
    if (!file_exists($fileName)) {
        throw new Exception("File not found: " . $fileName);
    }

    // Read the JSON file
    $json = file_get_contents($fileName);

    // Check if file was read correctly
    if ($json ===  false) {
        throw new Exception("Could not read the file: " . $fileName);
    }

    // Decode the JSON file
    $data = json_decode($json, true);

    // Check if decoding was successful
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("JSON decoding error: " . json_last_error_msg());
    }

    return $data;
}