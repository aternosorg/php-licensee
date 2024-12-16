<?php

namespace Aternos\Licensee\License\Text;

use Aternos\Licensee\Generated\Field;
use Aternos\Licensee\TextTransformer\AmpersandsTransformer;
use Aternos\Licensee\TextTransformer\BordersTransformer;
use Aternos\Licensee\TextTransformer\BulletTransformer;
use Aternos\Licensee\TextTransformer\DashTransformer;
use Aternos\Licensee\TextTransformer\GenericStripTitleTransformer;
use Aternos\Licensee\TextTransformer\HtmlTransformer;
use Aternos\Licensee\TextTransformer\HttpsTransformer;
use Aternos\Licensee\TextTransformer\HyphenatedTransformer;
use Aternos\Licensee\TextTransformer\ListTransformer;
use Aternos\Licensee\TextTransformer\LowercaseTransformer;
use Aternos\Licensee\TextTransformer\QuoteTransformer;
use Aternos\Licensee\TextTransformer\SpanMarkupTransformer;
use Aternos\Licensee\TextTransformer\SpellingTransformer;
use Aternos\Licensee\TextTransformer\StripBlockMarkupTransformer;
use Aternos\Licensee\TextTransformer\StripBomTransformer;
use Aternos\Licensee\TextTransformer\StripCC0OptionalTransformer;
use Aternos\Licensee\TextTransformer\StripCCOptionalTransformer;
use Aternos\Licensee\TextTransformer\StripCommentsTransformer;
use Aternos\Licensee\TextTransformer\StripCopyrightTransformer;
use Aternos\Licensee\TextTransformer\StripDevelopedByTransformer;
use Aternos\Licensee\TextTransformer\StripEndOfTermsTransformer;
use Aternos\Licensee\TextTransformer\StripHrsTransformer;
use Aternos\Licensee\TextTransformer\StripLinkMarkupTransformer;
use Aternos\Licensee\TextTransformer\StripMarkdownHeadings;
use Aternos\Licensee\TextTransformer\StripMitOptionalTransformer;
use Aternos\Licensee\TextTransformer\StripUnlicenseOptionalTransformer;
use Aternos\Licensee\TextTransformer\StripUrlTransformer;
use Aternos\Licensee\TextTransformer\StripVersionTransformer;
use Aternos\Licensee\TextTransformer\StripWhitespaceTransformer;
use Aternos\Licensee\TextTransformer\TextTransformer;

class LicenseText
{
    protected array $transformers;
    protected ?string $normalizedContent = null;
    protected ?array $wordSet = null;
    protected ?array $normalizedFields = null;
    protected ?array $uniqueNormalizedFields = null;
    protected ?bool $potentialCCFalsePositives = null;

    /**
     * @param string $content
     * @param string $filename
     */
    public function __construct(
        protected string $content,
        protected string $filename
    )
    {
        $titleTransformer = new GenericStripTitleTransformer();
        $versionTransformer = new StripVersionTransformer();

        $this->transformers = [
            new StripHrsTransformer(),
            new StripCommentsTransformer(),
            new StripMarkdownHeadings(),
            new StripLinkMarkupTransformer(),
            $titleTransformer,
            $versionTransformer,
            new LowercaseTransformer(),
            new ListTransformer(),
            new HttpsTransformer(),
            new AmpersandsTransformer(),
            new DashTransformer(),
            new QuoteTransformer(),
            new HyphenatedTransformer(),
            new SpellingTransformer(),
            new SpanMarkupTransformer(),
            new BulletTransformer(),
            new StripBomTransformer(),
            new StripCCOptionalTransformer(),
            new StripCC0OptionalTransformer(),
            new StripUnlicenseOptionalTransformer(),
            new BordersTransformer(),
            $titleTransformer,
            $versionTransformer,
            new StripUrlTransformer(),
            new StripCopyrightTransformer(),
            $titleTransformer,
            new StripBlockMarkupTransformer(),
            new StripDevelopedByTransformer(),
            new StripEndOfTermsTransformer(),
            new StripWhitespaceTransformer(),
            new StripMitOptionalTransformer()
        ];

        if (str_ends_with(strtolower($this->filename), ".html")) {
            array_unshift($this->transformers, new HtmlTransformer());
        }
    }

    /**
     * @return string
     */
    public function getNormalizedContent(): string
    {
        if ($this->normalizedContent === null) {
            $this->normalizedContent = $this->content;
            foreach ($this->transformers as $transformer) {
                $this->normalizedContent = $transformer->transform($this->normalizedContent);
                $this->normalizedContent = preg_replace("# +#", " ", $this->normalizedContent);
                $this->normalizedContent = trim($this->normalizedContent);
            }
        }
        return $this->normalizedContent;
    }

    /**
     * @return int
     */
    public function getNormalizedLength(): int
    {
        return strlen($this->getNormalizedContent());
    }

    /**
     * @return string[]
     */
    public function getWordSet(): array
    {
        if (!isset($this->wordSet)) {
            $matches = [];
            if (preg_match_all('/(?:[\w\/-](?:\'s|(?<=s)\')?)+/', $this->getNormalizedContent(), $matches)) {
                $this->wordSet = array_unique($matches[0]);
            } else {
                $this->wordSet = [];
            }
        }
        return $this->wordSet;
    }

    /**
     * @return string[]
     */
    public function getFieldlessWordSet(): array
    {
        return array_diff($this->getWordSet(), $this->getUniqueNormalizedFields());
    }

    /**
     * @param LicenseText $other
     * @return float
     */
    public function getSimilarity(LicenseText $other): float
    {
        $wordSet = $this->getFieldlessWordSet();
        $overlap = count(array_intersect($wordSet, $other->getWordSet()));
        $total = count($wordSet) + count($other->getWordSet()) - count($this->getUniqueNormalizedFields());
        return ($overlap * 200.0) / ($total + intdiv($this->getVariationAdjustedLengthDelta($other), 4));
    }

    /**
     * @param LicenseText $other
     * @return int
     */
    protected function getLengthDelta(LicenseText $other): int
    {
        return abs($this->getNormalizedLength() - $other->getNormalizedLength());
    }

    /**
     * @param LicenseText $other
     * @return int
     */
    protected function getVariationAdjustedLengthDelta(LicenseText $other): int
    {
        return $this->getLengthDelta($other);
    }

    /**
     * @return string[]
     */
    public function getNormalizedFields(): array
    {
        if ($this->normalizedFields !== null) {
            return $this->normalizedFields;
        }
        preg_match_all(Field::getKeyRegex(), $this->getNormalizedContent(), $matches);
        return $this->normalizedFields = array_values($matches[1]);
    }

    /**
     * @return string[]
     */
    public function getUniqueNormalizedFields(): array
    {
        if ($this->uniqueNormalizedFields !== null) {
            return $this->uniqueNormalizedFields;
        }
        return $this->uniqueNormalizedFields = array_unique($this->getNormalizedFields());
    }

    /**
     * @return bool
     */
    public function hasPotentialCCFalsePositives(): bool
    {
        if ($this->potentialCCFalsePositives !== null) {
            return $this->potentialCCFalsePositives;
        }
        return $this->potentialCCFalsePositives = !!preg_match('/^(creative commons )?Attribution-(NonCommercial|NoDerivatives)/i', $this->content) > 0;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }
}
