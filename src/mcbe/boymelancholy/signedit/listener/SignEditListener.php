<?php

namespace mcbe\boymelancholy\signedit\listener;

use mcbe\boymelancholy\signedit\event\BreakSignEvent;
use mcbe\boymelancholy\signedit\event\InteractSignEvent;
use mcbe\boymelancholy\signedit\form\HomeForm;
use pocketmine\event\Listener;

class SignEditListener implements Listener
{
    public function onInteractSign(InteractSignEvent $event)
    {
        $player = $event->getPlayer();
        $sign = $event->getSign();
        $player->sendForm(new HomeForm($sign));
    }

    public function onBreakSign(BreakSignEvent $event)
    {
        $player = $event->getPlayer();
        $sign = $event->getSign();
        // TODO: 文字付きの看板アイテムをドロップ
    }
}