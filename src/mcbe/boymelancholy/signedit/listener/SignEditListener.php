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

namespace mcbe\boymelancholy\signedit\listener;

use mcbe\boymelancholy\signedit\event\BreakSignEvent;
use mcbe\boymelancholy\signedit\event\InteractSignEvent;
use mcbe\boymelancholy\signedit\form\HomeForm;
use mcbe\boymelancholy\signedit\util\SignWriter;
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

        $writer = new SignWriter();
        $writer->setBaseSign($sign);
        $writtenSign = $writer->publish();
        $player->getWorld()->dropItem($sign->getPosition(), $writtenSign);
    }
}