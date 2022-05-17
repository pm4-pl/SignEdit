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

use boymelancholy\signedit\event\BreakSignEvent;
use pocketmine\block\BaseSign;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\item\ItemIds;

class PlayerBlockBreakListener implements Listener
{
    public function onBreakSign(BlockBreakEvent $event)
    {
        $block = $event->getBlock();
        if (!$block instanceof BaseSign) return;

        $item = $event->getItem();
        if ($item->getId() !== ItemIds::FEATHER) return;

        $lines = $block->getText()->getLines();
        $check[] = $lines[0] === "";
        $check[] = $lines[1] === "";
        $check[] = $lines[2] === "";
        $check[] = $lines[3] === "";
        if (!in_array(false, $check)) return;

        $event->setDrops([]);

        $ev = new BreakSignEvent($block, $event->getPlayer());
        $ev->call();
    }
}