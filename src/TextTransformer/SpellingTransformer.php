<?php

namespace Aternos\Licensee\TextTransformer;

class SpellingTransformer extends TextTransformer
{
    const array VARIETAL_WORDS = [
        'acknowledgment' => 'acknowledgement',
        'analogue' => 'analog',
        'analyse' => 'analyze',
        'artefact' => 'artifact',
        'authorisation' => 'authorization',
        'authorised' => 'authorized',
        'calibre' => 'caliber',
        'cancelled' => 'canceled',
        'capitalisations' => 'capitalizations',
        'catalogue' => 'catalog',
        'categorise' => 'categorize',
        'centre' => 'center',
        'emphasised' => 'emphasized',
        'favour' => 'favor',
        'favourite' => 'favorite',
        'fulfil' => 'fulfill',
        'fulfilment' => 'fulfillment',
        'initialise' => 'initialize',
        'judgment' => 'judgement',
        'labelling' => 'labeling',
        'labour' => 'labor',
        'licence' => 'license',
        'maximise' => 'maximize',
        'modelled' => 'modeled',
        'modelling' => 'modeling',
        'offence' => 'offense',
        'optimise' => 'optimize',
        'organisation' => 'organization',
        'organise' => 'organize',
        'practise' => 'practice',
        'programme' => 'program',
        'realise' => 'realize',
        'recognise' => 'recognize',
        'signalling' => 'signaling',
        'sub-license' => 'sublicense',
        'sub license' => 'sublicense',
        'utilisation' => 'utilization',
        'whilst' => 'while',
        'wilful' => 'wilfull',
        'non-commercial' => 'noncommercial',
        'per cent' => 'percent',
        'copyright owner' => 'copyright holder'
    ];

    /**
     * @inheritDoc
     */
    public function transform(string $text): string
    {
        foreach (self::VARIETAL_WORDS as $word => $replacement) {
            $text = preg_replace("/\b" . $word . "\b/i", $replacement, $text);
        }
        return $text;
    }
}
