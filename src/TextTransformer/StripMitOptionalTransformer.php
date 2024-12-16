<?php

namespace Aternos\Licensee\TextTransformer;

class StripMitOptionalTransformer extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct('/\(including the next paragraph\)/i');
    }
}
