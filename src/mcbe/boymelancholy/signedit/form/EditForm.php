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
use pocketmine\form\Form;
use pocketmine\player\Player;

class EditForm implements Form
{
    private BaseSign $sign;

    public function __construct(BaseSign $sign)
    {
        $this->sign = $sign;
    }

    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) {
            $player->sendForm(new HomeForm($this->sign));
            return;
        }
        $this->sign->setText(new SignText($data));
        $player->getWorld()->setBlock($this->sign->getPosition(), $this->sign);
    }

    public function jsonSerialize()
    {
        $signText = $this->sign->getText();

        $formArray["type"] = "custom_form";
        $formArray["title"] = Language::get("form.edit.title");
        for ($i = 0; $i < 4; ++$i) {
            $content["type"] = "input";
            $content["text"] = Language::get("form.edit.label", [(string)($i + 1)]);
            $content["default"] = $signText->getLine($i);
            $formArray["content"][] = $content;
        }
        return $formArray;
    }
}