<?php

namespace Aternos\Licensee\TextTransformer;

class DashTransformer extends RegexReplaceTransformer
{
    public function __construct()
    {
        parent::__construct('/(?<!^)([—–-]+)(?!$)/mu', '-');
    }
}
