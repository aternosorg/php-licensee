<?php

namespace Aternos\Licensee\TextTransformer;

class StripMarkdownHeadings extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct("/^\s*#+/m");
    }
}
