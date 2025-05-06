<?php

namespace Aternos\Licensee\TextTransformer;

use Aternos\Licensee\Exception\RegExpException;

class BulletTransformer extends TextTransformer
{

    /**
     * @inheritDoc
     */
    public function transform(string $text): string
    {
        $text = RegExpException::handleNull(preg_replace('/\n\n\s*(?:[*-]|\(?[\da-z]{1,2}[).])\s+/i', "\n\n- ", $text));
        return RegExpException::handleNull(preg_replace('/\)\s+\(/', ')(', $text));
    }
}
