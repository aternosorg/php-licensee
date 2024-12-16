<?php

namespace Aternos\Licensee\TextTransformer;

class StripVersionTransformer extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct("/\A\s*version.*$/im");
    }
}
