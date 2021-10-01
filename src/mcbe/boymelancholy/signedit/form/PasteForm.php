<?php

namespace mcbe\boymelancholy\signedit\form;

use mcbe\boymelancholy\signedit\util\TextClipboard;
use pocketmine\block\BaseSign;
use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\player\Player;

class PasteForm implements Form
{
    private BaseSign $sign;
    private Player $player;

    public function __construct(BaseSign $sign, Player $player) {
        $this->sign = $sign;
        $this->player = $player;
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
        if (is_bool($data)) {
            if ($data) {
                $player->sendForm(new HomeForm($this->sign));
            }
            return;
        }

        $signText = TextClipboard::getClipBoard($player)?->get($data);
        $this->sign->setText($signText);
        $player->getWorld()->setBlock($this->sign->getPosition(), $this->sign, true);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $clipboard = TextClipboard::getClipBoard($this->player);
        $formJson = [];
        $formJson['title'] = 'SignEdit　> ペースト';
        if ($clipboard->size() == 0) {
            $formJson['type'] = 'modal';
            $formJson['content'] = '何もコピーされていません';
            $formJson['button1'] = '戻る';
            $formJson['button2'] = '終わる';
        } else {
            $formJson['type'] = 'form';
            $formJson['content'] = '貼り付けたい文字を選択してください';
            foreach ($clipboard->getAll() as $item) {
                $formJson['buttons'][] = [
                    'text' => implode('/', $item->getLines())
                ];
            }
        }
        return $formJson;
    }
}