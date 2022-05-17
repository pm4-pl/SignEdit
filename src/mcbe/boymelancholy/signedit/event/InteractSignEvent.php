<?php

declare(strict_types=1);

namespace mcbe\boymelancholy\signedit\event;

use pocketmine\block\BaseSign;
use pocketmine\player\Player;

class InteractSignEvent extends SignEditEvent
{
    public function __construct(BaseSign $sign, Player $player)
    {
        $this->player = $player;
        $this->signBlock = $sign;
    }
}