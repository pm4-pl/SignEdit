<?php

namespace mcbe\boymelancholy\signedit\util;

use mcbe\boymelancholy\signedit\SignEdit;
use pocketmine\player\Player;
use pocketmine\scheduler\ClosureTask;

class InteractFlag
{
    private static array $flags;

    public static function set(Player $player, bool $value = true)
    {
        self::$flags[$player->getName()] = $value;
        if (!$value) return;

        SignEdit::$instance->getScheduler()->scheduleDelayedTask(
            new ClosureTask(
                function() use($player): void {
                    unset(self::$flags[$player->getName()]);
                }
            ),
            20
        );
    }

    public static function get(Player $player): Bool
    {
        return self::$flags[$player->getName()] ?? false;
    }
}