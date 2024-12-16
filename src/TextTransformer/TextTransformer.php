<?php

namespace Aternos\Licensee\TextTransformer;

abstract class TextTransformer
{
    /**
     * @param string $text
     * @return string
     */
    abstract public function transform(string $text): string;
}
