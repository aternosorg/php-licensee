<?php

namespace Aternos\Licensee\TextTransformer;

class QuoteTransformer extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct('/[`\'"‘“’”]/u', "'");
    }
}
