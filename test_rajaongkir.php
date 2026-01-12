<?php

use Illuminate\Support\Facades\Http;

require __DIR__.'/vendor/autoload.php';

$key = 'gUXkXm2p62cdfe623282af5fMtlnJYvZ';
$endpoints = ['starter', 'basic', 'pro'];

echo "Testing Key: $key\n";

foreach ($endpoints as $type) {
    echo "Testing $type...\n";
    $url = "https://api.rajaongkir.com/$type/province";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["key: $key"]);
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "Status: $httpCode\n";
    $json = json_decode($result, true);
    if (isset($json['rajaongkir']['status']['description'])) {
        echo "Response: " . $json['rajaongkir']['status']['description'] . "\n";
    } else {
        echo "Raw Response: " . substr($result, 0, 100) . "...\n";
    }
    echo "----------------\n";
}
