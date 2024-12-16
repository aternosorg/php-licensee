<?php

namespace Aternos\Licensee\TextTransformer;

class StripUnlicenseOptionalTransformer extends TextTransformer
{
    /**
     * @inheritDoc
     */
    public function transform(string $text): string
    {
        if (str_contains($text, "unlicense")) {
            $text = preg_replace('/For more information, please.*\S+unlicense\S+/im', ' ', $text);
        }
        return $text;
    }
}
