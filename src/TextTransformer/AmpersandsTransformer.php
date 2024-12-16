<?php

namespace Aternos\Licensee\TextTransformer;

class AmpersandsTransformer extends TextTransformer
{
    /**
     * @inheritDoc
     */
    public function transform(string $text): string
    {
        return str_replace("&", "and", $text);
    }
}
