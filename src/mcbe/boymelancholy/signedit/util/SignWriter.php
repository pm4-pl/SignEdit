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

namespace mcbe\boymelancholy\signedit\util;

use pocketmine\block\BaseSign;
use pocketmine\block\Block;
use pocketmine\item\ItemBlockWallOrFloor;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\math\Facing;
use pocketmine\nbt\tag\CompoundTag;

class SignWriter
{
    private const UNIQUE_TAG = "sign_edit_unique_tag";

    /** @var BaseSign */
    private BaseSign $baseSign;

    /** @var CompoundTag|null */
    private ?CompoundTag $compoundTag = null;

    /** @var Block|null */
    private ?Block $floorSign = null;

    /** @var Block|null */
    private ?Block $wallSign = null;

    /**
     * @param BaseSign $baseSign
     */
    public function setBaseSign(BaseSign $baseSign)
    {
        $this->baseSign = $baseSign;
        $this->floorSign = $baseSign->getPickedItem()->getBlock();
        $this->wallSign = $baseSign->getPickedItem()->getBlock(Facing::EAST);
        $this->compoundTag = $baseSign->getPickedItem(true)->getCustomBlockData();
    }

    /**
     * @return ItemBlockWallOrFloor
     */
    public function publish() : ItemBlockWallOrFloor
    {
        $item = new ItemBlockWallOrFloor(
            new ItemIdentifier(ItemIds::SIGN_POST, 0),
            $this->floorSign,
            $this->wallSign
        );

        $text = implode("+", $this->baseSign->getText()->getLines());
        $text = strtolower(preg_replace("/§./", "", $text));
        $item->getNamedTag()->setString(self::UNIQUE_TAG, $text);

        $lore = [$item->getName() . " (+Data)"];
        foreach ($this->baseSign->getText()->getLines() as $line) {
            $lore[] = " > §r§f" . $line;
        }
        $item->setLore($lore);

        $nbt = $this->compoundTag ?? new CompoundTag();
        $item->setCustomBlockData($nbt);

        return $item;
    }
}