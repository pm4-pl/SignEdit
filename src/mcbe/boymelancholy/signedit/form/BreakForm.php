<?php

namespace mcbe\boymelancholy\signedit\form;

use mcbe\boymelancholy\signedit\util\WrittenSign;
use pocketmine\block\BaseSign;
use pocketmine\form\Form;
use pocketmine\player\Player;

class BreakForm implements Form
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
        if (!is_bool($data)) return;

        $writtenSign = new WrittenSign($this->sign->getText());
        if ($data) {
            $writtenSign->setStandable();
        } else {
            $writtenSign->setHangable();
        }

        $player->getWorld()->dropItem($this->sign->getPosition(), $writtenSign->create());
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'type' => 'modal',
            'title' => 'SignEdit > テキスト保持',
            'content' => 'テキストを保持して削除する場合の形式を選んでください'."\n".'ただ壊す場合はこのウィンドウを閉じてください',
            'button1' => '設置型',
            'button2' => '壁掛型'
        ];
    }
}