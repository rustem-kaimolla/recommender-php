<?php

use PHPUnit\Framework\TestCase;
use Recommender\Storage\InMemoryStorage;
use Recommender\Similarity\JaccardSimilarity;
use Recommender\Algorithms\ItemItemCollaborativeFiltering;

class ItemItemCollaborativeFilteringTest extends TestCase
{
    public function testRecommendationWithClearUserItemOverlap()
    {
        $storage = new InMemoryStorage();
        $similarity = new JaccardSimilarity();
        $algorithm = new ItemItemCollaborativeFiltering($storage, $similarity);

        $storage->addInteraction(1, 10);
        $storage->addInteraction(1, 12);

        $storage->addInteraction(2, 10);
        $storage->addInteraction(2, 11);

        $storage->addInteraction(3, 11);

        $recommendations = $algorithm->recommend(1, 5);

        $this->assertNotEmpty($recommendations);
        $this->assertEquals(11, $recommendations[0]['item_id']);
        $this->assertGreaterThan(0, $recommendations[0]['score']);
    }

    public function testEmptyRecommendationIfUserHasNoItems()
    {
        $storage = new InMemoryStorage();
        $similarity = new JaccardSimilarity();
        $algorithm = new ItemItemCollaborativeFiltering($storage, $similarity);

        $recommendations = $algorithm->recommend(99, 5);

        $this->assertIsArray($recommendations);
        $this->assertCount(0, $recommendations);
    }

    public function testRecommendationExcludesAlreadyOwnedItems()
    {
        $storage = new InMemoryStorage();
        $similarity = new JaccardSimilarity();
        $algorithm = new ItemItemCollaborativeFiltering($storage, $similarity);

        $storage->addInteraction(1, 100);
        $storage->addInteraction(2, 100);
        $storage->addInteraction(2, 200);

        $recommendations = $algorithm->recommend(1, 5);

        $this->assertNotEmpty($recommendations);
        $this->assertEquals(200, $recommendations[0]['item_id']);
        $this->assertNotContains(100, array_column($recommendations, 'item_id'));
    }
}
