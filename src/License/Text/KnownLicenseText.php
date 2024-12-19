<?php

namespace Aternos\Licensee\License\Text;

use Aternos\Licensee\License\License;

class KnownLicenseText extends LicenseText
{
    /**
     * @param string $content
     * @param License $license
     */
    public function __construct(
        string            $content,
        protected License $license
    )
    {
        parent::__construct($content, $this->license->getKey() . ".txt");
    }

    /**
     * @inheritDoc
     */
    protected function getVariationAdjustedLengthDelta(LicenseText $other): int
    {
        $delta = $this->getLengthDelta($other);

        $adjustedDelta = $delta - max(count($this->getNormalizedFields()), $this->license->getAltSegmentCount()) * 5;
        return max($adjustedDelta, 0);
    }
}
