<?php

declare(strict_types=1);

require_once __DIR__ . "/service.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    showcase_json([
        "success" => false,
        "message" => "Method not allowed.",
    ], 405);
}

$id = filter_input(
    INPUT_POST,
    "id",
    FILTER_VALIDATE_INT
);

if (!$id) {
    showcase_json([
        "success" => false,
        "message" => "Invalid post.",
    ], 422);
}

$visitorKey = hash(
    "sha256",
    ($_SERVER["REMOTE_ADDR"] ?? "unknown") .
    "|" .
    ($_SERVER["HTTP_USER_AGENT"] ?? "unknown")
);

$database = showcase_database();

$repository = new ShowcaseRepository($database);

if (!$repository->find($id)) {
    showcase_json([
        "success" => false,
        "message" => "Post not found.",
    ], 404);
}

$repository->like($id, $visitorKey);

showcase_json([
    "success" => true,
]);