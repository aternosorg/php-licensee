<?php

namespace Aternos\Licensee\TextTransformer;

use Aternos\Licensee\Exception\RegExpException;

class StripCommentsTransformer extends TextTransformer
{
    const string COMMENT_MARKUP = "/^\s*?[\/*]{1,2}/m";

    /**
     * @inheritDoc
     */
    public function transform(string $text): string
    {
        $lines = explode("\n", $text);
        if (count($lines) === 1) {
            return $text;
        }

        $hasComment = true;
        foreach ($lines as $line) {
            $hasComment = $hasComment && RegExpException::handleFalse(preg_match(static::COMMENT_MARKUP, $line));
        }

        if ($hasComment) {
            return RegExpException::handleNull(preg_replace(static::COMMENT_MARKUP, ' ', $text));
        }

        return $text;
    }
}
