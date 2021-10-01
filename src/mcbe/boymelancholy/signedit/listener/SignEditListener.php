<?php

namespace mcbe\boymelancholy\signedit\listener;

use mcbe\boymelancholy\signedit\event\BreakSignEvent;
use mcbe\boymelancholy\signedit\event\InteractSignEvent;
use mcbe\boymelancholy\signedit\form\HomeForm;
use pocketmine\event\Listener;
use pocketmine\item\ItemFactory;
use pocketmine\nbt\tag\CompoundTag;

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
        $signText = $event->getSignText();

        $drop = ItemFactory::getInstance()->get(63, 0, 1);
        $tag = new CompoundTag();
        $tag->setString('Text1', $signText->getLine(0));
        $tag->setString('Text2', $signText->getLine(1));
        $tag->setString('Text3', $signText->getLine(2));
        $tag->setString('Text4', $signText->getLine(3));
        $drop->setCustomBlockData($tag);
        $player->getWorld()->dropItem($sign->getPosition(), $drop);
    }
}