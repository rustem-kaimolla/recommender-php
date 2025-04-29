<?php

use PHPUnit\Framework\TestCase;
use Recommender\Similarity\JaccardSimilarity;

class JaccardSimilarityTest extends TestCase
{
    public function testFullOverlap()
    {
        $sim = new JaccardSimilarity();
        $score = $sim->calculate([1, 2, 3], [1, 2, 3]);

        $this->assertEquals(1.0, $score, 'A perfect match should give 1.0');
    }

    public function testNoOverlap()
    {
        $sim = new JaccardSimilarity();
        $score = $sim->calculate([1, 2, 3], [4, 5, 6]);

        $this->assertEquals(0.0, $score, 'No common elements - 0.0');
    }

    public function testPartialOverlap()
    {
        $sim = new JaccardSimilarity();
        $score = $sim->calculate([1, 2], [2, 3]);

        $this->assertEqualsWithDelta(0.333, $score, 0.001);
    }

    public function testOneEmpty()
    {
        $sim = new JaccardSimilarity();
        $score = $sim->calculate([], [1, 2]);

        $this->assertEquals(0.0, $score);
    }

    public function testBothEmpty()
    {
        $sim = new JaccardSimilarity();
        $score = $sim->calculate([], []);

        $this->assertEquals(0.0, $score);
    }
}
