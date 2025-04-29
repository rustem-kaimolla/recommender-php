<?php

namespace Recommender\Algorithms;

use Recommender\Storage\StorageInterface;
use Recommender\Similarity\SimilarityInterface;

class ItemItemCollaborativeFiltering
{
    private StorageInterface $storage;
    private SimilarityInterface $similarity;

    public function __construct(StorageInterface $storage, SimilarityInterface $similarity)
    {
        $this->storage = $storage;
        $this->similarity = $similarity;
    }

    public function recommend(int $userId, int $limit = 5): array
    {
        $userItems = $this->storage->getItemsByUser($userId);
        if (empty($userItems)) {
            return [];
        }

        $scores = [];

        foreach ($userItems as $item) {
            $usersWhoInteracted = $this->storage->getUsersByItem($item);

            foreach ($usersWhoInteracted as $otherUserId) {
                foreach ($this->storage->getItemsByUser($otherUserId) as $otherItemId) {
                    if (in_array($otherItemId, $userItems, true)) {
                        continue;
                    }

                    $usersA = $this->storage->getUsersByItem($item);
                    $usersB = $this->storage->getUsersByItem($otherItemId);
                    $similarityScore = $this->similarity->calculate($usersA, $usersB);

                    if (!isset($scores[$otherItemId])) {
                        $scores[$otherItemId] = 0.0;
                    }

                    $scores[$otherItemId] = max($scores[$otherItemId], $similarityScore);
                }
            }
        }

        arsort($scores);

        return array_slice(
            array_map(fn($itemId, $score) => ['item_id' => $itemId, 'score' => $score], array_keys($scores), $scores),
            0,
            $limit
        );
    }

    public function getStorage(): StorageInterface
    {
        return $this->storage;
    }
}