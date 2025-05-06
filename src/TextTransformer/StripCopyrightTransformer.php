<?php

namespace Aternos\Licensee\TextTransformer;

use Aternos\Licensee\Exception\RegExpException;

class StripCopyrightTransformer extends TextTransformer
{
    const string PATTERN = '/\A\s*[_*\-\s]*(copyright|\(c\)|\xA9|\xC2\xA9).*(\n[_*\-\s]*with Reserved Font Name.*)?|\A\s*all rights reserved\.?$/im';


    /**
     * @inheritDoc
     */
    public function transform(string $text): string
    {
        while (RegExpException::handleFalse(preg_match(static::PATTERN, $text))) {
            $text = RegExpException::handleNull(preg_replace(static::PATTERN, ' ', $text));
        }
        return $text;
    }
}
