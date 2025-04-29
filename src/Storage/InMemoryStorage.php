<?php

namespace Recommender\Storage;

class InMemoryStorage implements StorageInterface
{
    private array $userItems = [];
    private array $itemUsers = [];

    public function addInteraction(int $userId, int $itemId): void
    {
        $this->userItems[$userId][$itemId] = true;
        $this->itemUsers[$itemId][$userId] = true;
    }

    public function getItemsByUser(int $userId): array
    {
        return array_keys($this->userItems[$userId] ?? []);
    }

    public function getUsersByItem(int $itemId): array
    {
        return array_keys($this->itemUsers[$itemId] ?? []);
    }
}
