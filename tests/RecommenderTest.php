<?php

use PHPUnit\Framework\TestCase;
use Recommender\Recommender;
use Recommender\Storage\InMemoryStorage;
use Recommender\Similarity\JaccardSimilarity;
use Recommender\Algorithms\ItemItemCollaborativeFiltering;

class RecommenderTest extends TestCase
{
    public function testBasicRecommendationFlow()
    {
        $storage = new InMemoryStorage();
        $similarity = new JaccardSimilarity();
        $algorithm = new ItemItemCollaborativeFiltering($storage, $similarity);
        $recommender = new Recommender($algorithm);

        $recommender->addInteraction(1, 10);
        $recommender->addInteraction(1, 12);
        $recommender->addInteraction(2, 10);
        $recommender->addInteraction(2, 11);
        $recommender->addInteraction(3, 11);

        $recommendations = $recommender->recommendForUser(1, 5);

        $this->assertNotEmpty($recommendations, 'Recommendations should not be empty.');
        $this->assertEquals(11, $recommendations[0]['item_id'], 'The first recommended item should be 11.');
        $this->assertGreaterThan(0, $recommendations[0]['score'], 'The score must be positive.');

        $this->assertArrayHasKey('item_id', $recommendations[0]);
        $this->assertArrayHasKey('score', $recommendations[0]);
    }
}
