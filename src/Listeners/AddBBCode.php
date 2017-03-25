<?php

namespace ClarkWinkelmann\ComicSans\Listeners;

use Flarum\Event\ConfigureFormatter;
use Illuminate\Contracts\Events\Dispatcher;

class AddBBCode
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(ConfigureFormatter::class, [$this, 'addBBCode']);
    }

    public function addBBCode(ConfigureFormatter $event)
    {
        $event->configurator->BBCodes->addCustom(
            '[COMIC]{TEXT}[/COMIC]',
            '<span class="comicsans">{TEXT}</span>'
        );
    }
}
