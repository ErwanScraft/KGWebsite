<?php

declare(strict_types=1);

require_once __DIR__ . "/storage.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    chat_json([
        "error" => "Method not allowed",
    ], 405);
}

$expectedSecret = chat_secret();

if ($expectedSecret === "") {
    chat_json([
        "error" => "Webhook secret is not configured",
    ], 500);
}

$authorization = $_SERVER["HTTP_AUTHORIZATION"] ?? "";

if (!preg_match("/^Bearer\s+(.+)$/i", $authorization, $matches)) {
    chat_json([
        "error" => "Unauthorized",
    ], 401);
}

$providedSecret = trim($matches[1]);

if (!hash_equals($expectedSecret, $providedSecret)) {
    chat_json([
        "error" => "Unauthorized",
    ], 401);
}

$body = file_get_contents("php://input");

if ($body === false || strlen($body) > 16384) {
    chat_json([
        "error" => "Invalid request body",
    ], 400);
}

$data = json_decode($body, true);

if (!is_array($data)) {
    chat_json([
        "error" => "Invalid JSON",
    ], 400);
}

if (($data["event"] ?? "") !== "player.chat") {
    chat_json([
        "ignored" => true,
    ]);
}

$player = $data["player"] ?? [];
$chat = $data["chat"] ?? [];

$playerName = trim((string) ($player["name"] ?? ""));
$message = trim((string) ($chat["message"] ?? ""));

if ($playerName === "" || $message === "") {
    chat_json([
        "error" => "Invalid chat payload",
    ], 422);
}

$playerName = mb_substr($playerName, 0, 32);
$message = mb_substr($message, 0, 256);

$database = chat_database();

$statement = $database->prepare(
    "INSERT INTO messages (
        player_name,
        message,
        created_at
    ) VALUES (
        :player_name,
        :message,
        :created_at
    )"
);

$statement->execute([
    ":player_name" => $playerName,
    ":message" => $message,
    ":created_at" => gmdate("c"),
]);

$database->exec(
    "DELETE FROM messages
     WHERE id NOT IN (
        SELECT id
        FROM messages
        ORDER BY id DESC
        LIMIT " . CHAT_MAX_MESSAGES . "
     )"
);

chat_json([
    "success" => true,
]);