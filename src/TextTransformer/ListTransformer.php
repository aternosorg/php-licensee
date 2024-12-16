<?php

namespace Aternos\Licensee\TextTransformer;

class ListTransformer extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct('/^\s*(?:\d\.|[*-])(?: [*_]{0,2}\(?[\da-z]\)[*_]{0,2})?\s+([^\n])/m', '- $1');
    }
}
