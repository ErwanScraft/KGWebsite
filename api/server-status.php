<?php

header("Content-Type: application/json; charset=utf-8");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("X-Content-Type-Options: nosniff");

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
    !is_array($config) ||
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

$baseUrl = rtrim(
    $config["api"]["baseUrl"],
    "/"
);

$address = trim(
    $config["server"]["address"]
);

if ($address === "") {
    http_response_code(500);

    echo json_encode([
        "error" => "Invalid server address"
    ]);

    exit;
}

$endpoint =
    $baseUrl .
    "/" .
    rawurlencode($address);

$timeout = max(
    1,
    (int) ceil(
        $config["api"]["timeout"] / 1000
    )
);

if (!function_exists("curl_init")) {
    http_response_code(500);

    echo json_encode([
        "error" => "cURL is not available"
    ]);

    exit;
}

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

if ($response === false) {
    curl_close($ch);

    http_response_code(502);

    echo json_encode([
        "error" => "Server status request failed"
    ]);

    exit;
}

$statusCode = curl_getinfo(
    $ch,
    CURLINFO_HTTP_CODE
);

curl_close($ch);

if (
    $statusCode < 200 ||
    $statusCode >= 300
) {
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

/*
 * Normalize upstream response.
 */

$online = $data["online"] ?? false;

$playersOnline =
    $data["players"]["online"] ?? 0;

$playersMax =
    $data["players"]["max"] ?? 0;

$hostname =
    $data["hostname"] ??
    $address;

$port =
    $data["port"] ??
    null;

$version =
    $data["version"] ??
    null;

$gamemode =
    $data["gamemode"] ??
    null;

$motd = "";

if (
    isset($data["motd"]["clean"]) &&
    is_array($data["motd"]["clean"]) &&
    isset($data["motd"]["clean"][0])
) {
    $motd = trim(
        (string) $data["motd"]["clean"][0]
    );
}

$result = [
    "online" => $online === true,

    "players" => [
        "online" => max(
            0,
            (int) $playersOnline
        ),

        "max" => max(
            0,
            (int) $playersMax
        )
    ],

    "hostname" => $hostname,
    "port" => $port,
    "version" => $version,
    "gamemode" => $gamemode,
    "motd" => $motd
];

echo json_encode(
    $result,
    JSON_UNESCAPED_SLASHES |
    JSON_UNESCAPED_UNICODE
);