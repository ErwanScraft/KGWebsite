<?php

declare(strict_types=1);

require_once __DIR__ . "/service.php";

$database = showcase_database();

$repository = new ShowcaseRepository($database);
$service = new ShowcaseService($repository);

showcase_json([
    "success" => true,
    "posts" => $service->getPublished(),
]);