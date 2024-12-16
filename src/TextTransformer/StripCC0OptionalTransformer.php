<?php

namespace Aternos\Licensee\TextTransformer;

class StripCC0OptionalTransformer extends TextTransformer
{
    /**
     * @inheritDoc
     */
    public function transform(string $text): string
    {
        if (str_contains($text, "associating cc0")) {
            $text = preg_replace('/^\s*Creative Commons Legal Code\s*$/im', ' ', $text);
            $text = preg_replace('/For more information, please see\s*\S+zero\S+/im', ' ', $text);
            $text = preg_replace('/CREATIVE COMMONS CORPORATION[\s\S]*?\n\n/im', ' ', $text);
        }
        return $text;
    }
}
