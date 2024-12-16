<?php

namespace Aternos\Licensee\TextTransformer;

class BulletTransformer extends TextTransformer
{

    /**
     * @inheritDoc
     */
    public function transform(string $text): string
    {
        $text = preg_replace('/\n\n\s*(?:[*-]|\(?[\da-z]{1,2}[).])\s+/i', "\n\n- ", $text);
        return preg_replace('/\)\s+\(/', ')(', $text);
    }
}
