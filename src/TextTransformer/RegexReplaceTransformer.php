<?php

namespace Aternos\Licensee\TextTransformer;

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
        return preg_replace($this->regex, $this->replacement, $text);
    }
}
