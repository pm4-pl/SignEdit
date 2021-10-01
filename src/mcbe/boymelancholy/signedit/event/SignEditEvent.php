<?php

namespace mcbe\boymelancholy\signedit\event;

use pocketmine\block\BaseSign;
use pocketmine\block\utils\SignText;
use pocketmine\event\Event;

abstract class SignEditEvent extends Event
{
    protected BaseSign $signBlock;

    public function getSign(): BaseSign
    {
        return $this->signBlock;
    }

    public function getSignText(): SignText
    {
        return $this->signBlock->getText();
    }
}