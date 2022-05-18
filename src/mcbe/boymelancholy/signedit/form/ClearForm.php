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

use mcbe\boymelancholy\signedit\lang\Language;
use pocketmine\block\BaseSign;
use pocketmine\block\utils\SignText;
use pocketmine\player\Player;

class ClearForm extends SignEditForm
{
    public function __construct(BaseSign $sign)
    {
        $this->sign = $sign;
    }

    public function handleResponse(Player $player, $data) : void
    {
        if ($data === null) {
            $this->backToHome($player);
            return;
        }

        $this->sign->setText(new SignText());
        $player->getWorld()->setBlock($this->sign->getPosition(), $this->sign);
    }

    public function jsonSerialize() : array
    {
        $formArray["type"] = "modal";
        $formArray["title"] = Language::get("form.clear.title");
        $formArray["content"] = Language::get("form.clear.content");
        $formArray["button1"] = Language::get("form.clear.button1");
        $formArray["button2"] = Language::get("form.clear.button2");
        return $formArray;
    }
}