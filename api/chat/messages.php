<?php

declare(strict_types=1);

require_once __DIR__ . "/storage.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    chat_json([
        "error" => "Method not allowed",
    ], 405);
}

$after = filter_input(
    INPUT_GET,
    "after",
    FILTER_VALIDATE_INT
);

$after = max(0, $after ?: 0);

$database = chat_database();

if ($after === 0) {
    $statement = $database->query(
        "SELECT
            id,
            player_name,
            message,
            created_at
         FROM messages
         ORDER BY id DESC
         LIMIT 30"
    );

    $messages = array_reverse(
        $statement->fetchAll()
    );
} else {
    $statement = $database->prepare(
        "SELECT
            id,
            player_name,
            message,
            created_at
         FROM messages
         WHERE id > :after
         ORDER BY id ASC
         LIMIT 50"
    );

    $statement->execute([
        ":after" => $after,
    ]);

    $messages = $statement->fetchAll();
}

chat_json([
    "messages" => $messages,
]);