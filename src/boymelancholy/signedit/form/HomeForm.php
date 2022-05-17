<?php

declare(strict_types=1);

namespace boymelancholy\signedit\form;

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
        $formArray["title"] = "SignEdit";
        $formArray["content"] = "Please select the process you wish to execute.";
        $formArray["buttons"][]["text"] = "Edit";
        $formArray["buttons"][]["text"] = "Copy";
        $formArray["buttons"][]["text"] = "Paste";
        $formArray["buttons"][]["text"] = "Erase";
        return $formArray;
    }
}