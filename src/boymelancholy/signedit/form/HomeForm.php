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

use boymelancholy\signedit\lang\Language;
use pocketmine\block\BaseSign;
use pocketmine\form\Form;
use pocketmine\player\Player;

class HomeForm implements Form
{
    private BaseSign $sign;

    public function __construct(BaseSign $sign)
    {
        $this->sign = $sign;
    }

    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) return;

        switch ((int) $data) {
            case 0:
                $player->sendForm(new EditForm($this->sign));
                break;

            case 1:
                $player->sendForm(new CopyForm($this->sign));
                break;

            case 2:
                $player->sendForm(new PasteForm($this->sign, $player));
                break;

            case 3:
                $player->sendForm(new ClearForm($this->sign));
                break;
        }
    }

    public function jsonSerialize()
    {
        $formArray["type"] = "form";
        $formArray["title"] = Language::get("form.home.button.title");
        $formArray["content"] = Language::get("form.home.content");
        $formArray["buttons"][]["text"] = Language::get("form.home.button.edit");
        $formArray["buttons"][]["text"] = Language::get("form.home.button.copy");
        $formArray["buttons"][]["text"] = Language::get("form.home.button.paste");
        $formArray["buttons"][]["text"] = Language::get("form.home.button.clear");
        return $formArray;
    }
}