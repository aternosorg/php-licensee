<?php

namespace Aternos\Licensee\TextTransformer;

class StripHrsTransformer extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct("/^\s*[=\-*]{3,}\s*$/m");
    }
}
