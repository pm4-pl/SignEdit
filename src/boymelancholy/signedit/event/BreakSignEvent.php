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

namespace boymelancholy\signedit\event;

use pocketmine\block\BaseSign;
use pocketmine\player\Player;

class BreakSignEvent extends SignEditEvent
{
    public function __construct(BaseSign $sign, Player $player)
    {
        $this->player = $player;
        $this->signBlock = $sign;
    }
}