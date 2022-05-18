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
use pocketmine\block\BlockIdentifier;
use pocketmine\block\FloorSign;
use pocketmine\block\tile\Sign;
use pocketmine\block\tile\TileFactory;
use pocketmine\block\utils\TreeType;
use pocketmine\block\VanillaBlocks;
use pocketmine\block\WallSign;
use pocketmine\item\ItemBlock;
use pocketmine\item\ItemIdentifier;

class SignPainter
{
    /** @var BaseSign */
    private BaseSign $baseSign;

    /** @var bool */
    private bool $isFloor = false;

    /** @var bool */
    private bool $isWall = false;

    /** @var TreeType|null */
    private ?TreeType $treeType = null;

    public function __construct()
    {
        if (!self::$ready) self::preparePallet();
    }

    /**
     * @param BaseSign $baseSign
     */
    public function setBaseSign(BaseSign $baseSign)
    {
        $this->baseSign = $baseSign;

        foreach (self::$floorSigns as $floorSign) {
            if ($floorSign->isSameType($baseSign)) {
                $this->isFloor = true;
                break;
            }
        }
        foreach (self::$wallSigns as $wallSign) {
            if ($wallSign->isSameType($baseSign)) {
                $this->isWall = true;
                break;
            }
        }
    }

    /**
     * @param TreeType $treeType
     */
    public function setTreeType(TreeType $treeType)
    {
        $this->treeType = $treeType;
    }

    /**
     * @return bool
     */
    public function paint() : bool
    {
        if (!$this->isFloor && !$this->isWall) return false;
        if ($this->treeType === null) return false;
        $key = $this->treeType->getMagicNumber();
        $blocks = $this->isFloor ? self::$floorSigns : self::$wallSigns;

        if (!isset($blocks[$key])) return false;
        $base = $blocks[$key];

        $identifier = new BlockIdentifier(
            $base->getId(),
            $this->baseSign->getIdInfo()->getVariant(),
            $base->asItem()->getId(),
            Sign::class
        );

        $sign = match (true) {
            $base instanceof FloorSign => new FloorSign($identifier, $base->getName(), $base->getBreakInfo()),
            $base instanceof WallSign => new WallSign($identifier, $base->getName(), $base->getBreakInfo()),
            default => $this->baseSign
        };
        $sign->setText($this->baseSign->getText());

        if ($base instanceof FloorSign) {
            if ($this->baseSign instanceof FloorSign) {
                $sign->setRotation($this->baseSign->getRotation());
            }
        } else {
            if ($base instanceof WallSign) {
                if ($this->baseSign instanceof WallSign) {
                    $sign->readStateFromData($sign->getId(), $this->baseSign->getMeta());
                }
            }
        }

        $pos = $this->baseSign->getPosition();
        $world = $pos->getWorld();
        $world->setBlock($pos, $sign);
        return true;
    }


    /** @var bool */
    private static bool $ready = false;

    /** @var BaseSign[] */
    private static array $floorSigns = [];

    /** @var BaseSign[] */
    private static array $wallSigns = [];

    public static function preparePallet()
    {
        self::$floorSigns[] = VanillaBlocks::OAK_SIGN();
        self::$floorSigns[] = VanillaBlocks::SPRUCE_SIGN();
        self::$floorSigns[] = VanillaBlocks::BIRCH_SIGN();
        self::$floorSigns[] = VanillaBlocks::JUNGLE_SIGN();
        self::$floorSigns[] = VanillaBlocks::ACACIA_SIGN();
        self::$floorSigns[] = VanillaBlocks::DARK_OAK_SIGN();

        self::$wallSigns[] = VanillaBlocks::OAK_WALL_SIGN();
        self::$wallSigns[] = VanillaBlocks::SPRUCE_WALL_SIGN();
        self::$wallSigns[] = VanillaBlocks::BIRCH_WALL_SIGN();
        self::$wallSigns[] = VanillaBlocks::JUNGLE_WALL_SIGN();
        self::$wallSigns[] = VanillaBlocks::ACACIA_WALL_SIGN();
        self::$wallSigns[] = VanillaBlocks::DARK_OAK_WALL_SIGN();
        self::$ready = true;
    }
}