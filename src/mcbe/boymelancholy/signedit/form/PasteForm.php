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
use mcbe\boymelancholy\signedit\util\TextClipboard;
use pocketmine\block\BaseSign;
use pocketmine\player\Player;

class PasteForm extends SignEditForm
{
    /** @var Player */
    private Player $player;

    public function __construct(BaseSign $sign, Player $player)
    {
        $this->sign = $sign;
        $this->player = $player;
    }

    public function handleResponse(Player $player, $data) : void
    {
        if (is_bool($data)) {
            if ($data) $this->backToHome($player);
            return;
        }

        $signText = TextClipboard::getClipBoard($player)?->get($data);
        $this->sign->setText($signText);
        $player->getWorld()->setBlock($this->sign->getPosition(), $this->sign);
    }

    public function jsonSerialize() : array
    {
        $clipboard = TextClipboard::getClipBoard($this->player);
        $formJson["title"] = Language::get("form.paste.title");
        if ($clipboard->size() == 0) {
            $formJson["type"] = "modal";
            $formJson["content"] = Language::get("form.cannot_paste.content");
            $formJson["button1"] = Language::get("form.cannot_paste.button1");
            $formJson["button2"] = Language::get("form.cannot_paste.button2");
        } else {
            $formJson["type"] = "form";
            $formJson["content"] = Language::get("form.paste.content");
            foreach ($clipboard->getAll() as $item) {
                $formJson["buttons"][]["text"] = implode("/", $item->getLines());
            }
        }
        return $formJson;
    }
}