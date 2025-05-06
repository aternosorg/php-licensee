<?php

namespace Aternos\Licensee\TextTransformer;

use Aternos\Licensee\Exception\RegExpException;

class RegexReplaceTransformer extends TextTransformer
{
    /**
     * @param string $regex
     * @param string $replacement
     */
    public function __construct(
        protected string $regex,
        protected string $replacement = " "
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function transform(string $text): string
    {
        return RegExpException::handleNull(preg_replace($this->regex, $this->replacement, $text));
    }
}
