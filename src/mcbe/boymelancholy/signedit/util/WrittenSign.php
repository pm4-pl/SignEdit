<?php

declare(strict_types=1);

namespace mcbe\boymelancholy\signedit\util;

use pocketmine\block\BaseSign;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\Item;
use pocketmine\item\ItemBlockWallOrFloor;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\nbt\tag\CompoundTag;

class WrittenSign
{
    private BaseSign $baseSign;

    public function __construct(BaseSign $baseSign)
    {
        $this->baseSign = $baseSign;
    }

    public function create(): Item
    {
        $obj = new ItemBlockWallOrFloor(
            new ItemIdentifier(ItemIds::SIGN_POST, 0),
            VanillaBlocks::OAK_SIGN(),
            VanillaBlocks::OAK_WALL_SIGN()
        );

        $text = $this->baseSign->getText();

        $tag = new CompoundTag();
        $tag->setString("Text1", $text->getLine(0));
        $tag->setString("Text2", $text->getLine(1));
        $tag->setString("Text3", $text->getLine(2));
        $tag->setString("Text4", $text->getLine(3));
        $obj->setCustomBlockData($tag);

        $obj->setLore($text->getLines());
        return $obj;
    }
}