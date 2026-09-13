<?php

declare(strict_types=1);

require_once __DIR__ . "/storage.php";

final class ShowcaseRepository
{
    public function __construct(
        private readonly PDO $database
    ) {
    }

    public function create(array $data): int
    {
        $statement = $this->database->prepare(
            "INSERT INTO showcase_posts (
                member_name,
                caption,
                media_path,
                media_type,
                status,
                created_at
            ) VALUES (
                :member_name,
                :caption,
                :media_path,
                :media_type,
                'pending',
                :created_at
            )"
        );

        $statement->execute([
            "member_name" => $data["member_name"],
            "caption" => $data["caption"],
            "media_path" => $data["media_path"],
            "media_type" => $data["media_type"],
            "created_at" => gmdate("Y-m-d H:i:s"),
        ]);

        return (int) $this->database->lastInsertId();
    }

    public function getPublished(int $limit = 20): array
    {
        $statement = $this->database->prepare(
            "SELECT
                p.*,
                COUNT(l.id) AS likes
             FROM showcase_posts p
             LEFT JOIN showcase_likes l
                ON l.post_id = p.id
             WHERE p.status = 'published'
             GROUP BY p.id
             ORDER BY p.created_at DESC
             LIMIT :limit"
        );

        $statement->bindValue(":limit", $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getPending(): array
    {
        $statement = $this->database->query(
            "SELECT *
             FROM showcase_posts
             WHERE status = 'pending'
             ORDER BY created_at ASC"
        );

        return $statement->fetchAll();
    }

    public function find(int $id): ?array
    {
        $statement = $this->database->prepare(
            "SELECT *
             FROM showcase_posts
             WHERE id = :id
             LIMIT 1"
        );

        $statement->execute([
            "id" => $id,
        ]);

        $post = $statement->fetch();

        return $post ?: null;
    }

    public function approve(int $id): bool
    {
        $statement = $this->database->prepare(
            "UPDATE showcase_posts
             SET status = 'published'
             WHERE id = :id
             AND status = 'pending'"
        );

        $statement->execute([
            "id" => $id,
        ]);

        return $statement->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $statement = $this->database->prepare(
            "DELETE FROM showcase_posts
             WHERE id = :id"
        );

        $statement->execute([
            "id" => $id,
        ]);

        return $statement->rowCount() > 0;
    }

    public function like(int $postId, string $visitorKey): bool
    {
        $statement = $this->database->prepare(
            "INSERT OR IGNORE INTO showcase_likes (
                post_id,
                visitor_key,
                created_at
            ) VALUES (
                :post_id,
                :visitor_key,
                :created_at
            )"
        );

        $statement->execute([
            "post_id" => $postId,
            "visitor_key" => $visitorKey,
            "created_at" => gmdate("Y-m-d H:i:s"),
        ]);

        return $statement->rowCount() > 0;
    }
}