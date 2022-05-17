<?php

declare(strict_types=1);

namespace boymelancholy\signedit;

use boymelancholy\signedit\listener\PlayerBlockBreakListener;
use boymelancholy\signedit\listener\PlayerInteractListener;
use boymelancholy\signedit\listener\PlayerQuitListener;
use boymelancholy\signedit\listener\SignEditListener;
use pocketmine\plugin\PluginBase;

class SignEdit extends PluginBase
{
    public function onEnable(): void
    {
        $listeners = [
            new PlayerInteractListener(),
            new PlayerBlockBreakListener(),
            new PlayerQuitListener(),
            new SignEditListener()
        ];
        foreach ($listeners as $listener) {
            $this->getServer()->getPluginManager()->registerEvents($listener, $this);
        }
    }
}