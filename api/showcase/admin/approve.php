<?php

declare(strict_types=1);

require_once __DIR__ . "/../service.php";

showcase_require_admin();

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

$database = showcase_database();

$repository = new ShowcaseRepository($database);
$service = new ShowcaseService($repository);

if (!$service->approve($id)) {
    showcase_json([
        "success" => false,
        "message" => "Post not found or already processed.",
    ], 404);
}

showcase_json([
    "success" => true,
    "message" => "Post approved.",
]);