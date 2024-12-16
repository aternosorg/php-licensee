<?php

namespace Aternos\Licensee\TextTransformer;

class BordersTransformer extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct('/^[*-](.*?)[*-]$/m', '$1');
    }
}
