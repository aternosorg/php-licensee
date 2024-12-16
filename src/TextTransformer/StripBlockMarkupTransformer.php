<?php

namespace Aternos\Licensee\TextTransformer;

class StripBlockMarkupTransformer extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct('/^\s*>/m');
    }
}
