<?php

namespace Aternos\Licensee\TextTransformer;

use Aternos\Licensee\Exception\RegExpException;

class StripEndOfTermsTransformer extends TextTransformer
{

    /**
     * @inheritDoc
     */
    public function transform(string $text): string
    {
        $parts = RegExpException::handleFalse(preg_split('/^[\s#*_]*end of (the )?terms and conditions[\s#*_]*$/im', $text, 2));
        return $parts[0];
    }
}
