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

namespace boymelancholy\signedit\listener;

use boymelancholy\signedit\util\InteractFlag;
use boymelancholy\signedit\util\TextClipboard;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;

class PlayerQuitListener implements Listener
{
    public function onPlayerQuit(PlayerQuitEvent $event)
    {
        $player = $event->getPlayer();
        TextClipboard::deleteClipboard($player);
        InteractFlag::delete($player);
    }
}