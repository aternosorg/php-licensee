<?php

namespace Aternos\Licensee\TextTransformer;

use Aternos\Licensee\License\License;

class GenericStripTitleTransformer extends TextTransformer
{
    /**
     * @inheritDoc
     */
    public function transform(string $text): string
    {
        $licenses = License::getAll();
        $titles = [];
        foreach ($licenses as $license) {
            $titles[] = $license->getTitleRegex();
        }

        foreach ($licenses as $license) {
            if ($license->getTitle() === $license->getNameWithoutVersion()) {
                continue;
            }

            $titles[] = preg_quote($license->getNameWithoutVersion(), "/");
        }

        do {
            $match = false;
            foreach ($titles as $title) {
                $pattern = '/\A\s*\(?(?:the )?(' . $title . ').*?$/imu';
                if (preg_match($pattern, $text)) {
                    $text = preg_replace($pattern, " ", $text);
                    $match = true;
                }
            }
        } while ($match);
        return $text;
    }
}
