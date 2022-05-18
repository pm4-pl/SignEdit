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

namespace mcbe\boymelancholy\signedit\item;

use pocketmine\block\BaseSign;
use pocketmine\block\Block;
use pocketmine\block\utils\SignText;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\ItemBlockWallOrFloor;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\math\Facing;

class WrittenSign extends ItemBlockWallOrFloor
{
    private const UNIQUE_TAG = "sign_edit_unique_tag";

    /** @var SignText */
    private SignText $signText;

    /** @var Block */
    private Block $floorVariant;

    /** @var Block */
    private Block $wallVariant;

    /** @var string */
    private string $uniqueTag = "";

    public function __construct(?BaseSign $baseSign = null)
    {
        $identifier = new ItemIdentifier(ItemIds::SIGN_POST, 0);
        $this->signText = new SignText();
        $this->floorVariant = VanillaBlocks::OAK_SIGN();
        $this->wallVariant = VanillaBlocks::OAK_WALL_SIGN();
        if ($baseSign instanceof BaseSign) {
            $this->signText = $baseSign->getText();
            $this->floorVariant = $baseSign->getPickedItem()->getBlock();
            $this->wallVariant = $baseSign->getPickedItem()->getBlock(Facing::EAST);
            $this->setCustomBlockData($baseSign->getPickedItem(true)->getCustomBlockData());
            $this->monopolize();
        }
        parent::__construct($identifier, $this->floorVariant, $this->wallVariant);
    }

    /**
     * @return Block
     */
    public function getFloorVariant() : Block
    {
        return $this->floorVariant;
    }

    /**
     * @return Block
     */
    public function getWallVariant() : Block
    {
        return $this->wallVariant;
    }

    /**
     * @return SignText
     */
    public function getSignText() : SignText
    {
        return $this->signText;
    }

    /**
     * @return string
     */
    public function getUniqueTag() : string
    {
        return $this->uniqueTag;
    }

    /**
     * @param Block $floorVariant
     */
    public function setFloorVariant(Block $floorVariant)
    {
        $this->floorVariant = $floorVariant;
    }

    /**
     * @param Block $wallVariant
     */
    public function setWallVariant(Block $wallVariant)
    {
        $this->wallVariant = $wallVariant;
    }

    public function monopolize()
    {
        $text = implode("+", $this->signText->getLines());
        $text = strtolower(preg_replace("/§./", "", $text));
        $this->getNamedTag()->setString(self::UNIQUE_TAG, $text);
        $this->uniqueTag = $text;

        $lore = [$this->getName() . " (+Data)"];
        foreach ($this->signText->getLines() as $line) {
            $lore[] = " > §r§f" . $line;
        }
        $this->setLore($lore);
    }
}