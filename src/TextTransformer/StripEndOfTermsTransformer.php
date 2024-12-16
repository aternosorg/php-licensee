<?php

namespace Aternos\Licensee\TextTransformer;

class StripEndOfTermsTransformer extends TextTransformer
{

    /**
     * @inheritDoc
     */
    public function transform(string $text): string
    {
        $parts = preg_split('/^[\s#*_]*end of (the )?terms and conditions[\s#*_]*$/im', $text, 2);
        return $parts[0];
    }
}
