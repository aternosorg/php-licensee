<?php

namespace Aternos\Licensee\TextTransformer;

class StripWhitespaceTransformer extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct('/\s+/');
    }
}
