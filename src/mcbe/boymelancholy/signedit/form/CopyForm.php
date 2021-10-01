<?php

namespace mcbe\boymelancholy\signedit\form;

use mcbe\boymelancholy\signedit\util\TextClipboard;
use pocketmine\block\BaseSign;
use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\player\Player;

class CopyForm implements Form
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
        $signText = $this->sign->getText();
        $clipboard = TextClipboard::getClipBoard($player);
        $clipboard->add($signText);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'type' => 'modal',
            'title' => 'SignEdit > コピー',
            'content' => 'この看板の文字をコピーしますか',
            'button1' => 'はい',
            'button2' => 'いいえ'
        ];
    }
}