<?php

namespace Aternos\Licensee;

use Aternos\Licensee\Exception\RegExpException;
use Aternos\Licensee\License\License;
use Aternos\Licensee\License\Text\LicenseText;
use Aternos\Licensee\Matcher\DiceMatcher;
use Aternos\Licensee\Matcher\ExactMatcher;
use Aternos\Licensee\Matcher\Matcher;
use Aternos\Licensee\Matcher\MatcherResult;

class Licensee
{
    /**
     * Find a license with the given choosealicense.com ID or SPDX ID
     *
     * @param string $id
     * @return License|null
     */
    public function findLicenseById(string $id): ?License
    {
        $lowercaseId = strtolower($id);
        foreach (License::getAll() as $license) {
            if (strtolower($license->getKey()) === $lowercaseId || strtolower($license->getSpdxId()->value) === $lowercaseId) {
                return $license;
            }
        }
        return null;
    }

    /**
     * Find a license with the given title
     *
     * @param string $title
     * @param bool $allowMatchWithoutVersion - If true, the title can match without the version part of the license title
     * @return License|null
     * @throws RegExpException
     */
    public function findLicenseByTitle(string $title, bool $allowMatchWithoutVersion = false): ?License
    {
        foreach (License::getAll() as $license) {
            if (strtolower($license->getTitle()) === strtolower($title)) {
                return $license;
            }

            if (RegExpException::handleFalse(preg_match('/' . $license->getTitleRegex() . '/i', $title))) {
                return $license;
            }
        }

        if ($allowMatchWithoutVersion) {
            foreach (License::getAll() as $license) {
                if (RegExpException::handleFalse(preg_match('/' . preg_quote($license->getNameWithoutVersion(), "/") . '/i', $title))) {
                    return $license;
                }
            }
        }

        return null;
    }

    /**
     * Find a license by its content
     *
     * @param LicenseText $content
     * @param float $confidenceThreshold - The minimum confidence level for a match to be returned (0-100)
     * @return MatcherResult|null
     * @throws RegExpException
     */
    public function findLicenseByContent(LicenseText $content, float $confidenceThreshold = Matcher::CONFIDENCE_THRESHOLD): ?MatcherResult
    {
        $matchers = [
            new ExactMatcher($content),
            new DiceMatcher($content)
        ];

        /** @var class-string<Matcher> $matcher */
        foreach ($matchers as $matcher) {
            $match = $matcher->getMatch($confidenceThreshold);
            if ($match) {
                return $match;
            }
        }

        return null;
    }
}
