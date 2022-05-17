<?php

declare(strict_types=1);

namespace mcbe\boymelancholy\signedit\util;

use pocketmine\player\Player;

class InteractFlag
{
    /** @var float[] */
    private static array $lastSignTouchTime = [];

    /**
     * @param Player $player
     * @return float
     */
    public static function get(Player $player) : float
    {
        return self::$lastSignTouchTime[$player->getName()] ?? 0;
    }

    /**
     * @param Player $player
     */
    public static function update(Player $player)
    {
        self::$lastSignTouchTime[$player->getName()] = microtime(true);
    }

    /**
     * @param Player $player
     */
    public static function delete(Player $player)
    {
        unset(self::$lastSignTouchTime[$player->getName()]);
    }
}