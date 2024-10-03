<?php

function readJsonFile($fileName) {
    // Read the JSON file
    $json = file_get_contents($fileName);

    // Decode the JSON file
    $data = json_decode($json, true);

    return $data;
}