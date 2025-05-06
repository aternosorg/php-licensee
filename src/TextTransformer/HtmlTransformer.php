<?php

namespace Aternos\Licensee\TextTransformer;

use Aternos\Licensee\Exception\RegExpException;
use League\HTMLToMarkdown\HtmlConverter;

class HtmlTransformer extends TextTransformer
{
    protected HtmlConverter $converter;

    public function __construct()
    {
        $this->converter = new HtmlConverter([
            'strip_tags' => true,
            'remove_nodes' => 'style title',
            'header_style' => 'atx',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function transform(string $text): string
    {
        $md = $this->converter->convert($text);
        return RegExpException::handleNull(preg_replace('/<\?xml .*?\?>/', '', $md));
    }
}
