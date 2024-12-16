<?php

namespace Aternos\Licensee\Matcher;

use Aternos\Licensee\License\License;

class MatcherResult
{
    /**
     * @param License $license
     * @param float $confidence
     */
    public function __construct(
        protected License $license,
        protected float $confidence
    )
    {
    }

    /**
     * @return License
     */
    public function getLicense(): License
    {
        return $this->license;
    }

    /**
     * @return float
     */
    public function getConfidence(): float
    {
        return $this->confidence;
    }
}
