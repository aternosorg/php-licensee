<?php

namespace Aternos\Licensee\TextTransformer;

class HttpsTransformer extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct('/http:/', 'https:');
    }
}
