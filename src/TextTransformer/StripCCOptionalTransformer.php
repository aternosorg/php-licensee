<?php

namespace Aternos\Licensee\TextTransformer;

class StripCCOptionalTransformer extends TextTransformer
{
    /**
     * @inheritDoc
     */
    public function transform(string $text): string
    {
        if (str_contains($text, "creative commons")) {
            $text = preg_replace('/The\s+text\s+of\s+the\s+Creative\s+Commons[\s\S]*?Public\s+Domain\s+Dedication./im', ' ', $text);
            $text = preg_replace('/wiki.creativecommons.org/i', ' ', $text);
        }
        return $text;
    }
}
