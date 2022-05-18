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

namespace mcbe\boymelancholy\signedit\form;

use pocketmine\block\BaseSign;
use pocketmine\form\Form;
use pocketmine\player\Player;

abstract class SignEditForm implements Form
{
    /** @var BaseSign */
    protected BaseSign $sign;

    /**
     * @param Player $player
     */
    protected function backToHome(Player $player)
    {
        $player->sendForm(new HomeForm($this->sign));
    }
}