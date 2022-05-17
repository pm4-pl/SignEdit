<?php

declare(strict_types=1);

namespace boymelancholy\signedit\form;

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
        $formArray["title"] = "SignEdit > Edit";
        for ($i = 0; $i < 4; ++$i) {
            $content["type"] = "input";
            $content["text"] = "Line " . ($i + 1);
            $content["default"] = $signText->getLine($i);
            $formArray["content"][] = $content;
        }
        return $formArray;
    }
}