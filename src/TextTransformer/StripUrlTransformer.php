<?php

namespace Aternos\Licensee\TextTransformer;

class StripUrlTransformer extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct('/\A\s*https?:\/\/[^ ]+\n/');
    }
}
