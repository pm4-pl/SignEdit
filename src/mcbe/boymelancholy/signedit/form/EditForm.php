<?php

namespace mcbe\boymelancholy\signedit\form;

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

    /**
     * @inheritDoc
     */
    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) {
            $player->sendForm(new HomeForm($this->sign));
            return;
        }
        $this->sign->setText(new SignText($data));
        $player->getWorld()->setBlock($this->sign->getPosition(), $this->sign, true);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $signText = $this->sign->getText();
        return [
            'type' => 'custom_form',
            'title' => 'SignEdit > 編集',
            'content' => [
                [
                    'type' => 'input',
                    'text' => '一行目',
                    'default' => $signText->getLine(0)
                ],
                [
                    'type' => 'input',
                    'text' => '二行目',
                    'default' => $signText->getLine(1)
                ],
                [
                    'type' => 'input',
                    'text' => '三行目',
                    'default' => $signText->getLine(2)
                ],
                [
                    'type' => 'input',
                    'text' => '四行目',
                    'default' => $signText->getLine(3)
                ],
            ]
        ];
    }
}