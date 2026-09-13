<?php

declare(strict_types=1);

const SHOWCASE_STORAGE_DIR = __DIR__ . "/../../storage";
const SHOWCASE_DATABASE_PATH = SHOWCASE_STORAGE_DIR . "/showcase.sqlite";

const SHOWCASE_MEDIA_DIR = SHOWCASE_STORAGE_DIR . "/showcase";
const SHOWCASE_IMAGE_DIR = SHOWCASE_MEDIA_DIR . "/images";
const SHOWCASE_VIDEO_DIR = SHOWCASE_MEDIA_DIR . "/videos";

const SHOWCASE_MAX_IMAGE_SIZE = 8 * 1024 * 1024;
const SHOWCASE_MAX_VIDEO_SIZE = 50 * 1024 * 1024;

const SHOWCASE_ALLOWED_IMAGES = [
    "image/jpeg",
    "image/png",
    "image/webp",
];

const SHOWCASE_ALLOWED_VIDEOS = [
    "video/mp4",
    "video/webm",
];

function showcase_database(): PDO
{
    if (!is_dir(SHOWCASE_STORAGE_DIR)) {
        mkdir(SHOWCASE_STORAGE_DIR, 0750, true);
    }

    $database = new PDO(
        "sqlite:" . SHOWCASE_DATABASE_PATH,
        null,
        null,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    $database->exec(
        "CREATE TABLE IF NOT EXISTS showcase_posts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            member_name TEXT NOT NULL,
            caption TEXT NOT NULL,
            media_path TEXT NOT NULL,
            media_type TEXT NOT NULL,
            status TEXT NOT NULL DEFAULT 'pending',
            created_at TEXT NOT NULL
        )"
    );

    $database->exec(
        "CREATE TABLE IF NOT EXISTS showcase_likes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            post_id INTEGER NOT NULL,
            visitor_key TEXT NOT NULL,
            created_at TEXT NOT NULL,
            UNIQUE(post_id, visitor_key)
        )"
    );

    return $database;
}

function showcase_prepare_storage(): void
{
    foreach (
        [
            SHOWCASE_MEDIA_DIR,
            SHOWCASE_IMAGE_DIR,
            SHOWCASE_VIDEO_DIR,
        ] as $directory
    ) {
        if (!is_dir($directory)) {
            mkdir($directory, 0750, true);
        }
    }
}

function showcase_json(array $data, int $status = 200): never
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

function showcase_admin_key(): string
{
    return "TES1";
}

function showcase_require_admin(): void
{
    $configuredKey = showcase_admin_key();
    $providedKey = $_SERVER["HTTP_X_SHOWCASE_ADMIN_KEY"] ?? "";

    if (
        $configuredKey === "" ||
        $providedKey === "" ||
        !hash_equals($configuredKey, $providedKey)
    ) {
        showcase_json(
            [
                "success" => false,
                "message" => "Unauthorized.",
            ],
            401
        );
    }
}

function showcase_media_url(string $path): string
{
    return "../../storage/" . ltrim($path, "/");
}