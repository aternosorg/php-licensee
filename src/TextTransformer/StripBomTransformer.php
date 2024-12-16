<?php

namespace Aternos\Licensee\TextTransformer;

class StripBomTransformer extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct("/\A\s*\xEF\xBB\xBF/");
    }
}
