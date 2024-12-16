<?php

namespace Aternos\Licensee\TextTransformer;

class StripLinkMarkupTransformer extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct("/\[(.+?)\]\(.+?\)/", "$1");
    }
}
