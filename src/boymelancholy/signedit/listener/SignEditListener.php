<?php

declare(strict_types=1);

namespace boymelancholy\signedit\listener;

use boymelancholy\signedit\event\BreakSignEvent;
use boymelancholy\signedit\event\InteractSignEvent;
use boymelancholy\signedit\form\HomeForm;
use boymelancholy\signedit\util\WrittenSign;
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

        $writtenSign = new WrittenSign($sign);
        $player->getWorld()->dropItem($sign->getPosition(), $writtenSign->create());
    }
}