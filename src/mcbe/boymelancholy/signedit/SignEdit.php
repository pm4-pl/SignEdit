<?php

namespace mcbe\boymelancholy\signedit;

use mcbe\boymelancholy\signedit\listener\PlayerBlockBreakListener;
use mcbe\boymelancholy\signedit\listener\PlayerInteractListener;
use mcbe\boymelancholy\signedit\listener\PlayerQuitListener;
use mcbe\boymelancholy\signedit\listener\SignEditListener;
use pocketmine\plugin\PluginBase;

class SignEdit extends PluginBase
{
    public static PluginBase $instance;

    public function onEnable(): void
    {
        self::$instance = $this;
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