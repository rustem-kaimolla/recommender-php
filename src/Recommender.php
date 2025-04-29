<?php

namespace Recommender;

use Recommender\Algorithms\ItemItemCollaborativeFiltering;

class Recommender
{
    private ItemItemCollaborativeFiltering $algorithm;

    public function __construct(ItemItemCollaborativeFiltering $algorithm)
    {
        $this->algorithm = $algorithm;
    }

    public function addInteraction(int $userId, int $itemId): void
    {
        $this->algorithm->getStorage()->addInteraction($userId, $itemId);
    }

    public function recommendForUser(int $userId, int $limit = 5): array
    {
        return $this->algorithm->recommend($userId, $limit);
    }
}
