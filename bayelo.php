<?php
require "Item.php";

//this was generated by chatgpt. Please let me know if it breaks any copyright rules.
function update_ratings(Item $itemA, Item $itemB, $resultA) {
    $expectedA = expected_score($itemA->rating, $itemA->variance, $itemB->rating, $itemB->variance);
    $expectedB = 1 - $expectedA;

    $k = 32; // Sensitivity factor
    $itemA->rating = (int) ($itemA->rating + $k * ($resultA - $expectedA));
    $itemB->rating = (int) ($itemB->rating + $k * ((1 - $resultA) - $expectedB));

    $itemA->variance = (int) adjust_variance($itemA->variance, $expectedA, $resultA);
    $itemB->variance = (int) adjust_variance($itemB->variance, $expectedB, 1 - $resultA);
}

function expected_score($ratingA, $varianceA, $ratingB, $varianceB) {
    $combinedVariance = sqrt($varianceA * $varianceA + $varianceB * $varianceB);
    $ratingDifference = $ratingA - $ratingB;
    $expectedA = 1 / (1 + exp(-($ratingDifference) / $combinedVariance));

    return $expectedA;
}

function adjust_variance($currentVariance, $expected, $actual) {
    $learningRate = 0.2; // Control how quickly the variance changes
    $predictionError = abs($expected - $actual);

    $newVariance = $currentVariance * (1 + $learningRate * ($predictionError - 0.5));
    $newVariance = max(100, $newVariance);

    return $newVariance;
}
