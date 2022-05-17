<?php

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