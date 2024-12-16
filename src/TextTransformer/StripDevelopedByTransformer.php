<?php

namespace Aternos\Licensee\TextTransformer;

class StripDevelopedByTransformer extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct('/\A\s*developed by:[\s\S]*?\n\n/im');
    }
}
