<?php

namespace mcbe\boymelancholy\signedit\listener;

use mcbe\boymelancholy\signedit\event\InteractSignEvent;
use mcbe\boymelancholy\signedit\SignEdit;
use mcbe\boymelancholy\signedit\util\InteractFlag;
use pocketmine\block\BaseSign;
use pocketmine\block\Block;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\tile\Sign;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\ItemIds;

class PlayerInteractListener implements Listener
{
    /**
     * @param PlayerInteractEvent $event
     * @priority LOWEST
     */
    public function onCoolDown(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        if (InteractFlag::get($player)) {
            $event->cancel();
            return;
        }
        InteractFlag::set($player);
    }

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

        $ev = new InteractSignEvent($block, $event->getPlayer());
        $ev->call();
    }
}