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
use mcbe\boymelancholy\signedit\util\SignPainter;
use pocketmine\block\BaseSign;
use pocketmine\block\utils\TreeType;
use pocketmine\player\Player;

class PaintForm extends SignEditForm
{
    public function __construct(BaseSign $sign)
    {
        $this->sign = $sign;
    }

    public function handleResponse(Player $player, $data) : void
    {
        if ($data === null) {
            $this->backToHome($player);
            return;
        }

        $filteredTypes = array_filter(
            TreeType::getAll(),
            function (TreeType $type) use($data) {
                return $type->getMagicNumber() == (int) $data;
            }
        );
        if (!isset($filteredTypes[0])) return;
        $treeType = $filteredTypes[0];

        $painter = new SignPainter();
        $painter->setBaseSign($this->sign);
        $painter->setTreeType($treeType);
        $painter->paint();
    }

    public function jsonSerialize() : array
    {
        $formArray["type"] = "form";
        $formArray["title"] = Language::get("form.paint.title");
        $formArray["content"] = Language::get("form.paint.content");
        $formArray["buttons"][]["text"] = Language::get("form.paint.button.oak");
        $formArray["buttons"][]["text"] = Language::get("form.paint.button.spruce");
        $formArray["buttons"][]["text"] = Language::get("form.paint.button.birch");
        $formArray["buttons"][]["text"] = Language::get("form.paint.button.jungle");
        $formArray["buttons"][]["text"] = Language::get("form.paint.button.acacia");
        $formArray["buttons"][]["text"] = Language::get("form.paint.button.dark_oak");
        return $formArray;
    }
}