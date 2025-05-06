<?php

namespace Aternos\Licensee\TextTransformer;

use Aternos\Licensee\Exception\RegExpException;
use Aternos\Licensee\Generated\Constants;

class SpellingTransformer extends TextTransformer
{
    /**
     * @inheritDoc
     */
    public function transform(string $text): string
    {
        foreach (Constants::EQUIVALENT_WORDS as $to => $from) {
            $escapedFrom = [];
            foreach ($from as $word) {
                $escapedFrom[] = preg_quote($word, "/");
            }

            $pattern = "/\b(" . implode("|", $escapedFrom) . ")\b/i";
            $text = RegExpException::handleNull(preg_replace($pattern, $to, $text));
        }
        return $text;
    }
}
