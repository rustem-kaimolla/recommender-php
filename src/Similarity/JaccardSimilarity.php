<?php

namespace Recommender\Similarity;

class JaccardSimilarity implements SimilarityInterface
{
    public function calculate(array $usersA, array $usersB): float
    {
        if (empty($usersA) || empty($usersB)) {
            return 0.0;
        }

        $intersection = count(array_intersect($usersA, $usersB));
        $union = count(array_unique(array_merge($usersA, $usersB)));

        return $union > 0 ? $intersection / $union : 0.0;
    }
}
