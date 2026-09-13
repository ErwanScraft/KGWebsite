<?php

declare(strict_types=1);

require_once __DIR__ . "/repository.php";

final class ShowcaseService
{
    public function __construct(
        private readonly ShowcaseRepository $repository
    ) {
    }

    public function create(array $data): int
    {
        return $this->repository->create($data);
    }

    public function getPublished(): array
    {
        $posts = $this->repository->getPublished();

        foreach ($posts as &$post) {
            $post["media_url"] = "/storage/" . ltrim(
                $post["media_path"],
                "/"
            );

            unset($post["media_path"]);
        }

        return $posts;
    }

    public function getPending(): array
    {
        return $this->repository->getPending();
    }

    public function approve(int $id): bool
    {
        return $this->repository->approve($id);
    }

    public function reject(int $id): bool
    {
        $post = $this->repository->find($id);

        if (!$post) {
            return false;
        }

        $deleted = $this->repository->delete($id);

        if ($deleted) {
            $file = SHOWCASE_STORAGE_DIR . "/" .
                ltrim($post["media_path"], "/");

            if (is_file($file)) {
                unlink($file);
            }
        }

        return $deleted;
    }
}