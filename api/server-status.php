<?php

header("Content-Type: application/json; charset=utf-8");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

$configPath = __DIR__ . "/../assets/data/server.json";

if (!is_file($configPath)) {
    http_response_code(500);

    echo json_encode([
        "error" => "Server configuration not found"
    ]);

    exit;
}

$config = json_decode(
    file_get_contents($configPath),
    true
);

if (
    !isset($config["api"]["baseUrl"]) ||
    !isset($config["api"]["timeout"]) ||
    !isset($config["server"]["address"])
) {
    http_response_code(500);

    echo json_encode([
        "error" => "Invalid server configuration"
    ]);

    exit;
}

$endpoint =
    rtrim($config["api"]["baseUrl"], "/") .
    "/" .
    rawurlencode($config["server"]["address"]);

$timeout = max(
    1,
    (int) ceil($config["api"]["timeout"] / 1000)
);

$ch = curl_init($endpoint);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_TIMEOUT => $timeout,
    CURLOPT_HTTPHEADER => [
        "Accept: application/json",
        "User-Agent: KGSMP-Website/1.0"
    ]
]);

$response = curl_exec($ch);
$status = curl_getinfo(
    $ch,
    CURLINFO_HTTP_CODE
);

curl_close($ch);

if ($response === false) {
    http_response_code(502);

    echo json_encode([
        "error" => "Server status request failed"
    ]);

    exit;
}

if ($status < 200 || $status >= 300) {
    http_response_code(502);

    echo json_encode([
        "error" => "Server status API returned an error"
    ]);

    exit;
}

$data = json_decode(
    $response,
    true
);

if (!is_array($data)) {
    http_response_code(502);

    echo json_encode([
        "error" => "Invalid server status response"
    ]);

    exit;
}

echo json_encode($data);