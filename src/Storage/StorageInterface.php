<?php

namespace Recommender\Storage;

interface StorageInterface
{
    public function addInteraction(int $userId, int $itemId): void;

    public function getItemsByUser(int $userId): array;

    public function getUsersByItem(int $itemId): array;
}
