<?php

namespace Aternos\Licensee\TextTransformer;

use Aternos\Licensee\Exception\RegExpException;

abstract class TextTransformer
{
    /**
     * @param string $text
     * @return string
     * @throws RegExpException
     */
    abstract public function transform(string $text): string;
}
