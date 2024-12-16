<?php

namespace Tests;

use Aternos\Licensee\License\Text\LicenseText;
use Aternos\Licensee\Licensee;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DetectLicenseTest extends TestCase
{
    public static function licenseDataProvider(): array
    {
        return [
            'agpl-3.0_markdown' => ['agpl-3.0_markdown', 'agpl-3.0'],
            'apache-2.0_markdown' => ['apache-2.0_markdown', 'apache-2.0'],
            'apache-with-readme-notice' => ['apache-with-readme-notice', 'apache-2.0'],
            'artistic-2.0_markdown' => ['artistic-2.0_markdown', 'artistic-2.0'],
            'bom' => ['bom', 'mit'],
            'bsd-2-author' => ['bsd-2-author', 'bsd-2-clause'],
            'bsd-3-authorowner' => ['bsd-3-authorowner', 'bsd-3-clause'],
            'bsd-3-clause_markdown' => ['bsd-3-clause_markdown', 'bsd-3-clause'],
            'bsd-3-lists' => ['bsd-3-lists', 'bsd-3-clause'],
            'bsd-3-noendorseslash' => ['bsd-3-noendorseslash', 'bsd-3-clause'],
            'bsl' => ['bsl', 'bsl-1.0'],
            'case-sensitive' => ['case-sensitive', null],
            'cc-by-4.0_markdown' => ['cc-by-4.0_markdown', 'cc-by-4.0'],
            'cc-by-nc-sa' => ['cc-by-nc-sa', null],
            'cc-by-nd' => ['cc-by-nd', null],
            'cc-by-sa-4.0_markdown' => ['cc-by-sa-4.0_markdown', 'cc-by-sa-4.0'],
            'cc-by-sa-mdlinks' => ['cc-by-sa-mdlinks', 'cc-by-sa-4.0'],
            'cc-by-sa-nocclicensor' => ['cc-by-sa-nocclicensor', 'cc-by-sa-4.0'],
            'cc0-1.0_markdown' => ['cc0-1.0_markdown', 'cc0-1.0'],
            'cc0-cal2013' => ['cc0-cal2013', 'cc0-1.0'],
            'cc0-cc' => ['cc0-cc', 'cc0-1.0'],
            'crlf-bsd' => ['crlf-bsd', 'bsd-3-clause'],
            'crlf-license' => ['crlf-license', 'gpl-3.0'],
            'description-license' => ['description-license', null],
            'epl-1.0_markdown' => ['epl-1.0_markdown', 'epl-1.0'],
            'eupl-cal2017' => ['eupl-cal2017', 'eupl-1.2'],
            'fcpl-modified-mpl' => ['fcpl-modified-mpl', null],
            'gfdl-1.3_markdown' => ['gfdl-1.3_markdown', 'gfdl-1.3'],
            'gpl-2.0_markdown' => ['gpl-2.0_markdown', 'gpl-2.0'],
            'gpl-2.0_markdown_headings' => ['gpl-2.0_markdown_headings', 'gpl-2.0'],
            'gpl-3.0_markdown' => ['gpl-3.0_markdown', 'gpl-3.0'],
            'gpl3-without-instructions' => ['gpl3-without-instructions', 'gpl-3.0'],
            'html' => ['html', 'epl-1.0'],
            'lgpl' => ['lgpl', 'lgpl-3.0'],
            'lgpl-2.1_markdown' => ['lgpl-2.1_markdown', 'lgpl-2.1'],
            'lgpl-3.0_markdown' => ['lgpl-3.0_markdown', 'lgpl-3.0'],
            'license-in-parent-folder' => ['license-in-parent-folder', 'mit'],
            'license-with-readme-reference' => ['license-with-readme-reference', 'mit'],
            'mit' => ['mit', 'mit'],
            'mit-optional' => ['mit-optional', 'mit'],
            'mit-with-copyright' => ['mit-with-copyright', 'mit'],
            'mit_markdown' => ['mit_markdown', 'mit'],
            'mpl-2.0_markdown' => ['mpl-2.0_markdown', 'mpl-2.0'],
            'mpl-without-hrs' => ['mpl-without-hrs', 'mpl-2.0'],
            'multiple-arrs' => ['multiple-arrs', 'bsd-3-clause'],
            'pixar-modified-apache' => ['pixar-modified-apache', null],
            'unlicense-noinfo' => ['unlicense-noinfo', 'unlicense'],
            'unlicense_markdown' => ['unlicense_markdown', 'unlicense'],
            'vim' => ['vim', 'vim'],
            'wrk-modified-apache' => ['wrk-modified-apache', null],
        ];
    }

    /**
     * @param $path
     * @return LicenseText|null
     */
    protected function findLicense($path): ?LicenseText
    {
        foreach (scandir($path) as $file) {
            if (is_file($path . $file)) {
                $name = pathinfo($file, PATHINFO_FILENAME);
                if (str_contains(strtolower($name), "license")) {
                    return new LicenseText(file_get_contents($path . $file), $file);
                }
            }
        }
        return null;
    }

    #[DataProvider('licenseDataProvider')]
    public function testDetectLicense(string $license, ?string $expected): void
    {
        $licensee = new Licensee();
        $content = $this->findLicense(__DIR__ . "/Fixtures/$license/");
        $match = $licensee->findLicenseByContent($content);

        if ($expected === null) {
            $this->assertNull($match);
        } else {
            $this->assertNotNull($match);
            $this->assertEquals($expected, $match->getLicense()->getKey());
        }
    }
}
