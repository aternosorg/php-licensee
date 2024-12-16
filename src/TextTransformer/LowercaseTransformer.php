<?php

namespace Aternos\Licensee\TextTransformer;

class LowercaseTransformer extends TextTransformer
{

    /**
     * @inheritDoc
     */
    public function transform(string $text): string
    {
        return strtolower($text);
    }
}
