<?php

$key = 'gUXkXm2p62cdfe623282af5fMtlnJYvZ';
$endpoints = [
    'https://peruri.komerce.id/api/v1/province', // Common Komerce endpoint
    'https://collaborator.komerce.id/api/v1/province',
    'https://collaborator.komerce.id/api/province',
    'https://komerce.id/api/v1/province'
];

echo "Testing Komerce URLs with key: $key\n";

foreach ($endpoints as $url) {
    echo "Testing $url...\n";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // Try both header styles
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["key: $key", "Authorization: Bearer $key"]);
    
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "Status: $httpCode\n";
    echo "Response: " . substr($result, 0, 100) . "...\n";
    echo "----------------\n";
}
