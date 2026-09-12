<?php

declare(strict_types=1);

const CHAT_STORAGE_DIR = __DIR__ . "/../../storage";
const CHAT_DATABASE_PATH = CHAT_STORAGE_DIR . "/chat.sqlite";
const CHAT_MAX_MESSAGES = 100;

function chat_database(): PDO
{
    if (!is_dir(CHAT_STORAGE_DIR)) {
        mkdir(CHAT_STORAGE_DIR, 0750, true);
    }

    $database = new PDO(
        "sqlite:" . CHAT_DATABASE_PATH,
        null,
        null,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    $database->exec(
        "CREATE TABLE IF NOT EXISTS messages (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            player_name TEXT NOT NULL,
            message TEXT NOT NULL,
            created_at TEXT NOT NULL
        )"
    );

    return $database;
}

function chat_secret(): string
{
    return "sb_W5rNVT39ElsulcgT27X_290IhvDTrxh-4702Z1IsqaChSlq6cOYJwfnNgYlwOuB5
";
}

function chat_json(array $data, int $status = 200): never
{
    http_response_code($status);

    header("Content-Type: application/json; charset=utf-8");
    header("Cache-Control: no-store");

    echo json_encode(
        $data,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

    exit;
}