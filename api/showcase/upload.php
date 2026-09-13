<?php

declare(strict_types=1);

require_once __DIR__ . "/service.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    showcase_json([
        "success" => false,
        "message" => "Method not allowed.",
    ], 405);
}

showcase_prepare_storage();

$memberName = trim($_POST["member_name"] ?? "");
$caption = trim($_POST["caption"] ?? "");

if ($memberName === "" || $caption === "") {
    showcase_json([
        "success" => false,
        "message" => "Username and caption are required.",
    ], 422);
}

if (
    mb_strlen($memberName) > 32 ||
    mb_strlen($caption) > 500
) {
    showcase_json([
        "success" => false,
        "message" => "Input is too long.",
    ], 422);
}

if (
    !isset($_FILES["media"]) ||
    $_FILES["media"]["error"] !== UPLOAD_ERR_OK
) {
    showcase_json([
        "success" => false,
        "message" => "Media upload failed.",
    ], 422);
}

$file = $_FILES["media"];

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file["tmp_name"]);

$isImage = in_array(
    $mime,
    SHOWCASE_ALLOWED_IMAGES,
    true
);

$isVideo = in_array(
    $mime,
    SHOWCASE_ALLOWED_VIDEOS,
    true
);

if (!$isImage && !$isVideo) {
    showcase_json([
        "success" => false,
        "message" => "Unsupported media type.",
    ], 422);
}

$maxSize = $isImage
    ? SHOWCASE_MAX_IMAGE_SIZE
    : SHOWCASE_MAX_VIDEO_SIZE;

if ($file["size"] > $maxSize) {
    showcase_json([
        "success" => false,
        "message" => "Media file is too large.",
    ], 422);
}

$extension = match ($mime) {
    "image/jpeg" => "jpg",
    "image/png" => "png",
    "image/webp" => "webp",
    "video/mp4" => "mp4",
    "video/webm" => "webm",
    default => null,
};

if ($extension === null) {
    showcase_json([
        "success" => false,
        "message" => "Unsupported file.",
    ], 422);
}

$filename = bin2hex(random_bytes(16)) . "." . $extension;

$directory = $isImage
    ? SHOWCASE_IMAGE_DIR
    : SHOWCASE_VIDEO_DIR;

$relativeDirectory = $isImage
    ? "showcase/images"
    : "showcase/videos";

$destination = $directory . "/" . $filename;

if (!move_uploaded_file($file["tmp_name"], $destination)) {
    showcase_json([
        "success" => false,
        "message" => "Could not save media.",
    ], 500);
}

$database = showcase_database();

$repository = new ShowcaseRepository($database);
$service = new ShowcaseService($repository);

$id = $service->create([
    "member_name" => $memberName,
    "caption" => $caption,
    "media_path" => $relativeDirectory . "/" . $filename,
    "media_type" => $isImage ? "image" : "video",
]);

showcase_json([
    "success" => true,
    "id" => $id,
    "status" => "pending",
    "message" => "Showcase submitted for review.",
], 201);