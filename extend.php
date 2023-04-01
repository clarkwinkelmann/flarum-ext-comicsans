<?php

namespace ClarkWinkelmann\ComicSans;

use Flarum\Extend;
use s9e\TextFormatter\Configurator;
use s9e\TextFormatter\Utils;

const MAX_OFFSET = 15;
const MIN_OFFSET = 0;
const MAX_RANDOM_OFFSET_CHANGE = 5;

return [
    (new Extend\Frontend('forum'))
        ->css(__DIR__ . '/resources/less/forum.less'),
    (new Extend\Formatter)
        ->configure(function (Configurator $config) {
            $config->BBcodes->addCustom(
                '[COMIC]{TEXT}[/COMIC]',
                '<span class="comicsans">{TEXT}</span>'
            );

            $config->BBcodes->addCustom(
                '[COMIC-TABLE]{ANYTHING}[/COMIC-TABLE]',
                '<table class="comicsans-table">{ANYTHING}</table>'
            );

            $config->BBCodes->addFromRepository('THEAD');
            $config->BBCodes->addFromRepository('TBODY');
            $config->BBCodes->addFromRepository('TR');
            $config->BBCodes->addFromRepository('TH');
            $config->BBCodes->addFromRepository('TD');

            $tdTemplate = $config->tags['TD']->template->asDOM();

            foreach ($tdTemplate->getElementsByTagName('td') as $node) {
                $node->insertAdjacentXML(
                    'afterbegin',
                    '<xsl:if test="@offset">
                        <xsl:attribute name="style">--offset: <xsl:value-of select="@offset"/></xsl:attribute>
                    </xsl:if>'
                );
            }

            $tdTemplate->saveChanges();
        })
        ->render(function ($renderer, $context, $xml) {
            $offset = 0;

            return Utils::replaceAttributes($xml, 'TD', function ($attributes) use (&$offset) {
                $offset = max(min($offset + random_int(-min($offset - MIN_OFFSET, MAX_RANDOM_OFFSET_CHANGE), min(MAX_OFFSET - $offset, MAX_RANDOM_OFFSET_CHANGE)), MAX_OFFSET), MIN_OFFSET);

                return $attributes + [
                        'offset' => $offset,
                    ];
            });
        }),
];
