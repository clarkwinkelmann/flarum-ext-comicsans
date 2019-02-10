<?php

namespace ClarkWinkelmann\ComicSans;

use Flarum\Extend;
use s9e\TextFormatter\Configurator;

return [
    (new Extend\Frontend('forum'))
        ->css(__DIR__ . '/resources/less/forum/extension.less'),
    (new Extend\Formatter)
        ->configure(function (Configurator $config) {
            $config->BBcodes->addCustom(
                '[COMIC]{TEXT}[/COMIC]',
                '<span class="comicsans">{TEXT}</span>'
            );
        })
];
