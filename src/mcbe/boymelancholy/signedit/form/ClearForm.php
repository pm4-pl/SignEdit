<?php

namespace mcbe\boymelancholy\signedit\form;

use pocketmine\block\BaseSign;
use pocketmine\block\utils\SignText;
use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\player\Player;

class ClearForm implements Form
{
    private BaseSign $sign;

    public function __construct(BaseSign $sign) {
        $this->sign = $sign;
    }

    /**
     * @inheritDoc
     */
    public function handleResponse(Player $player, $data): void
    {
        if (!(bool) $data) {
            $player->sendForm(new HomeForm($this->sign));
            return;
        }
        $this->sign->setText(new SignText());
        $player->getWorld()->setBlock($this->sign->getPosition(), $this->sign, true);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'type' => 'modal',
            'title' => 'SignEdit > クリア',
            'content' => '本当に看板の文字をすべて削除しますか',
            'button1' => 'はい',
            'button2' => 'いいえ'
        ];
    }
}