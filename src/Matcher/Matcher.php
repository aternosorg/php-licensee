<?php

namespace Aternos\Licensee\Matcher;

use Aternos\Licensee\License\License;
use Aternos\Licensee\License\Text\LicenseText;

abstract class Matcher
{
    public const float CONFIDENCE_THRESHOLD = 98.0;

    /**
     * @param LicenseText $content
     */
    public function __construct(
        protected LicenseText $content
    )
    {
    }

    /**
     * @return License[]
     */
    protected function getPotentialMatches(): array
    {
        return License::getAll();
    }

    /**
     * @param License $license
     * @return float
     */
    abstract protected function match(License $license): float;

    /**
     * @return MatcherResult[]
     */
    public function getAllMatches(): array
    {
        $result = [];
        foreach ($this->getPotentialMatches() as $license) {
            $result[] = new MatcherResult($license, $this->match($license));
        }

        usort($result, function (MatcherResult $a, MatcherResult $b) {
            return $b->getConfidence() <=> $a->getConfidence();
        });

        return $result;
    }

    /**
     * @param float $confidenceThreshold
     * @return MatcherResult|null
     */
    public function getMatch(float $confidenceThreshold = self::CONFIDENCE_THRESHOLD): ?MatcherResult
    {
        $matches = $this->getAllMatches();
        if (count($matches) === 0 || $matches[0]->getConfidence() < $confidenceThreshold) {
            return null;
        }

        return $matches[0];
    }
}
