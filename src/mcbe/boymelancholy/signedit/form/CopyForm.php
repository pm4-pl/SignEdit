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
use mcbe\boymelancholy\signedit\util\TextClipboard;
use pocketmine\block\BaseSign;
use pocketmine\form\Form;
use pocketmine\player\Player;

class CopyForm extends SignEditForm
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

        $signText = $this->sign->getText();
        $clipboard = TextClipboard::getClipBoard($player);
        $clipboard->add($signText);
    }

    public function jsonSerialize() : array
    {
        $formArray["type"] = "modal";
        $formArray["title"] = Language::get("form.copy.title");
        $formArray["content"] = Language::get("form.copy.content");
        $formArray["button1"] = Language::get("form.copy.button1");
        $formArray["button2"] = Language::get("form.copy.button2");
        return $formArray;
    }
}