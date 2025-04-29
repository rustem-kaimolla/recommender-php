<?php

namespace Recommender\Similarity;

interface SimilarityInterface
{
    public function calculate(array $usersA, array $usersB): float;
}
