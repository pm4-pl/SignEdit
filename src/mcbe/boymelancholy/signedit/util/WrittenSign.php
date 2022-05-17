<?php

declare(strict_types=1);

namespace mcbe\boymelancholy\signedit\util;

use pocketmine\block\BaseSign;
use pocketmine\item\ItemBlockWallOrFloor;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\math\Facing;

class WrittenSign
{
    private BaseSign $baseSign;

    public function __construct(BaseSign $baseSign)
    {
        $this->baseSign = $baseSign;
    }

    /**
     * @return ItemBlockWallOrFloor
     */
    public function create(): ItemBlockWallOrFloor
    {
        $pickedItem = $this->baseSign->getPickedItem(true);

        $obj = new ItemBlockWallOrFloor(
            new ItemIdentifier(ItemIds::SIGN_POST, 0),
            $pickedItem->getBlock(),
            $pickedItem->getBlock(Facing::EAST)
        );

        $obj->setCustomBlockData($pickedItem->getCustomBlockData());
        $obj->getNamedTag()->setString("UNIQUE_TAG", $this->createUniqueTag());
        $lore = [$pickedItem->getName() . " (+Data)"];
        foreach ($this->baseSign->getText()->getLines() as $line) {
            $lore[] = " > §r§f" . $line;
        }
        $obj->setLore($lore);
        return $obj;
    }

    /**
     * @return string
     */
    private function createUniqueTag() : string
    {
        $text = implode("+", $this->baseSign->getText()->getLines());
        return strtolower(preg_replace("/§./", "", $text));
    }
}