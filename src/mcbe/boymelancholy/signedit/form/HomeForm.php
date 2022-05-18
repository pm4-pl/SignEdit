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
use pocketmine\form\Form;
use pocketmine\player\Player;

class HomeForm extends SignEditForm
{
    public function __construct(BaseSign $sign)
    {
        $this->sign = $sign;
    }

    public function handleResponse(Player $player, $data) : void
    {
        if ($data === null) return;

        $form = match ((int) $data) {
            0 => new EditForm($this->sign),
            1 => new CopyForm($this->sign),
            2 => new PasteForm($this->sign, $player),
            3 => new PaintForm($this->sign),
            4 => new ClearForm($this->sign),
            default => null
        };

        if ($form === null) return;

        $player->sendForm($form);
    }

    public function jsonSerialize() : array
    {
        $formArray["type"] = "form";
        $formArray["title"] = Language::get("form.home.title");
        $formArray["content"] = Language::get("form.home.content");
        $formArray["buttons"][]["text"] = Language::get("form.home.button.edit");
        $formArray["buttons"][]["text"] = Language::get("form.home.button.copy");
        $formArray["buttons"][]["text"] = Language::get("form.home.button.paste");
        $formArray["buttons"][]["text"] = Language::get("form.home.button.paint");
        $formArray["buttons"][]["text"] = Language::get("form.home.button.clear");
        return $formArray;
    }
}