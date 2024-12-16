<?php

namespace Aternos\Licensee\Matcher;

use Aternos\Licensee\License\License;

class DiceMatcher extends Matcher
{
    /**
     * @inheritDoc
     */
    protected function getPotentialMatches(): array
    {
        $result = [];
        foreach (parent::getPotentialMatches() as $license) {
            if ($license->isCreativeCommons() && $this->content->hasPotentialCCFalsePositives()) {
                continue;
            }
            $result[] = $license;
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    protected function match(License $license): float
    {
        return $license->getText()->getSimilarity($this->content);
    }
}
