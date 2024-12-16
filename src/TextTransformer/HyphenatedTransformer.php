<?php

namespace Aternos\Licensee\TextTransformer;

class HyphenatedTransformer extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct('/(\w+)-\s*\n\s*(\w+)/', '$1-$2');
    }
}
