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

use boymelancholy\signedit\util\TextClipboard;
use pocketmine\block\BaseSign;
use pocketmine\form\Form;
use pocketmine\player\Player;

class CopyForm implements Form
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
        $signText = $this->sign->getText();
        $clipboard = TextClipboard::getClipBoard($player);
        $clipboard->add($signText);
    }

    public function jsonSerialize()
    {
        $formArray["type"] = "modal";
        $formArray["title"] = "SignEdit > Copy";
        $formArray["content"] = "Do you want to copy the text on this sign?";
        $formArray["button1"] = "Yes";
        $formArray["button2"] = "No";
        return $formArray;
    }
}