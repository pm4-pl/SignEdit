<?php

declare(strict_types=1);

namespace mcbe\boymelancholy\signedit\listener;

use mcbe\boymelancholy\signedit\event\BreakSignEvent;
use pocketmine\block\BaseSign;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\item\ItemIds;

class PlayerBlockBreakListener implements Listener
{
    public function onBreakSign(BlockBreakEvent $event)
    {
        $item = $event->getItem();
        if ($item->getId() !== ItemIds::FEATHER) return;

        $block = $event->getBlock();
        if (!$block instanceof BaseSign) return;

        $event->setDrops([]);

        $ev = new BreakSignEvent($block, $event->getPlayer());
        $ev->call();
    }
}