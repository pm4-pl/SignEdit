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

use mcbe\boymelancholy\signedit\event\InteractSignEvent;
use mcbe\boymelancholy\signedit\util\InteractFlag;
use pocketmine\block\BaseSign;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\ItemIds;

class PlayerInteractListener implements Listener
{
    /**
     * @param PlayerInteractEvent $event
     * @ignoreCancelled
     */
    public function onTap(PlayerInteractEvent $event)
    {
        $item = $event->getItem();
        if ($item->getId() !== ItemIds::FEATHER) return;

        $block = $event->getBlock();
        if (!$block instanceof BaseSign) return;

        $action = $event->getAction();
        if ($action !== PlayerInteractEvent::RIGHT_CLICK_BLOCK) return;

        $player = $event->getPlayer();
        if (InteractFlag::get($player) + 1 < microtime(true)) {
            $ev = new InteractSignEvent($block, $player);
            $ev->call();
            InteractFlag::update($player);
        }
    }
}