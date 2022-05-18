<?php
/**
 *
 *  _____ _         _____   _ _ _
 * |   __|_|___ ___|   __|_| |_| |_
 * |__   | | . |   |   __| . | |  _|
 * |_____|_|_  |_|_|_____|___|_|_|
 *         |___|
 *
 * Sign editor for PocketMine-MP
 *
 * @author boymelancholy
 * @link https://github.com/boymelancholy/SignEdit/
 *
 */
declare(strict_types=1);

namespace mcbe\boymelancholy\signedit;

use mcbe\boymelancholy\signedit\lang\Language;
use mcbe\boymelancholy\signedit\listener\PlayerBlockBreakListener;
use mcbe\boymelancholy\signedit\listener\PlayerInteractListener;
use mcbe\boymelancholy\signedit\listener\PlayerQuitListener;
use mcbe\boymelancholy\signedit\listener\SignEditListener;
use pocketmine\plugin\PluginBase;

class SignEdit extends PluginBase
{
    public function onEnable() : void
    {
        $this->registerLanguage();
        $this->registerListeners();
    }

    private function registerLanguage()
    {
        $lang = $this->getConfig()->get("language", "eng");
        Language::load($this, $lang);

        $langName = Language::get("language.name");
        $message = Language::get("language.selected", [$langName, $lang]);
        $this->getLogger()->info($message);
    }

    private function registerListeners()
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