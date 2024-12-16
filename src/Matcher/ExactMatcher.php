<?php

namespace Aternos\Licensee\Matcher;

use Aternos\Licensee\License\License;

class ExactMatcher extends Matcher
{

    /**
     * @inheritDoc
     */
    protected function match(License $license): float
    {
        if ($license->getText()->getWordSet() === $this->content->getWordSet()) {
            return 100;
        } else {
            return 0;
        }
    }
}
