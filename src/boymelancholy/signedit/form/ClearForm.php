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

namespace boymelancholy\signedit\form;

use pocketmine\block\BaseSign;
use pocketmine\block\utils\SignText;
use pocketmine\form\Form;
use pocketmine\player\Player;

class ClearForm implements Form
{
    private BaseSign $sign;

    public function __construct(BaseSign $sign)
    {
        $this->sign = $sign;
    }

    public function handleResponse(Player $player, $data): void
    {
        if (!$data) {
            $player->sendForm(new HomeForm($this->sign));
            return;
        }
        $this->sign->setText(new SignText());
        $player->getWorld()->setBlock($this->sign->getPosition(), $this->sign);
    }

    public function jsonSerialize()
    {
        $formArray["type"] = "modal";
        $formArray["title"] = "SignEdit > Erase";
        $formArray["content"] = "Do you really want to remove all the text from the sign?";
        $formArray["button1"] = "Yes";
        $formArray["button2"] = "No";
        return $formArray;
    }
}