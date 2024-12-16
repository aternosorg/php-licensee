<?php

namespace Aternos\Licensee\TextTransformer;

class SpanMarkupTransformer extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct('/[_*~]+(.*?)[_*~]+/', '$1');
    }
}
