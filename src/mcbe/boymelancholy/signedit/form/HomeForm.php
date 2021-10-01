<?php

namespace mcbe\boymelancholy\signedit\form;

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

    /**
     * @inheritDoc
     */
    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) {
            return;
        }
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

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'type' => 'form',
            'title' => 'SignEdit',
            'content' => '実行したい処理を選択してください',
            'buttons' => [
                [
                    'text' => '編集'
                ],
                [
                    'text' => 'コピー'
                ],
                [
                    'text' => 'ペースト'
                ],
                [
                    'text' => 'クリア'
                ]
            ]
        ];
    }
}